<?php

abstract class HttpCodes
{
	const OK = 200;
	const CREATED = 201;
	const NOT_MODIFIED = 304;
}

class v3
{
	const GEOMETRIA_PUNTUA = 1;
	const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';

	const ANONYMOUS_USER_ID = 'anonymous';
	const ENTITY_USER_ID = 'udala';

	const USER_TYPE_ANONYMOUS = 0;
	const USER_TYPE_USER = 1;
	const USER_TYPE_GUEST = 2;

	private $request;
	private $path;

	private $userType;
	private $user;

	public function parseRequest(sfWebRequest $request, $response, &$result)
	{
		if (!$this->checkAuth($request))
			throw new Exception('Invalid credentials', HttpErrors::INVALID_CREDENTIALS);

		$this->request = $request;
		$this->response = $response;

		sfContext::getInstance()->getLogger()->debug($this->request->getContent());

		$this->path = explode('/', $request->getPathInfo());
		$this->getNextPath(); // root
		$this->getNextPath(); // method
		$this->getNextPath(); // action

		$resource = array_shift($this->path);
		switch ($resource)
		{
			case 'issues':
				$this->parseIssues($result);
				break;

			case 'users':
				// disable everything under users
				throw new Exception('Not allowed', HttpErrors::METHOD_NOT_ALLOWED);

				$this->parseUsers($result);
				break;

			case 'ping':
				$this->ping();
				break;

			default:
				throw new Exception('Resource not found', HttpErrors::NOT_FOUND);
		}
	}

	private function parseIssues(&$result)
	{
		$id = $this->getNextPath();
		switch ($id)
		{
			case NULL:
				if ($this->request->getMethod() !== 'POST')
					throw new Exception('Method not implemented', HttpErrors::METHOD_NOT_ALLOWED);

				if ($this->request->getContentType() !== 'application/json')
					throw new Exception('Invalid data format', HttpErrors::BAD_REQUEST);

				$issueId = $this->addIssue($this->request->getContent());
				$result = $this->getIssue($issueId);

				$this->response->setStatusCode(HttpCodes::CREATED);
				$this->response->setHttpHeader('Location', $this->request->getPathInfo() . $issueId);

				break;

			default:
				$this->parseIssuesId($result, $id);
				break;
		}
	}

	private function parseIssuesId(&$result, $id)
	{
		if ($this->getNextPath() !== NULL)
			throw new Exception('Method not implemented', HttpErrors::METHOD_NOT_ALLOWED);

		switch ($this->request->getMethod())
		{
			case 'PATCH':
			case 'POST':
				if ($this->request->getContentType() !== 'application/json'
				 && $this->request->getContentType() !== 'application/merge-patch+json')
					throw new Exception('Invalid data format', HttpErrors::BAD_REQUEST);

				$issueId = $this->updateIssue($id, $this->request->getContent());
				$result = $this->getIssue($issueId);

				break;
			case 'GET':
			case 'HEAD':
				$result = $this->getIssue($id);

				break;
			default:
				throw new Exception('Method not implemented', HttpErrors::METHOD_NOT_ALLOWED);
		}
	}

	private function checkAuth($request)
	{
		$this->user = NULL;

		if (!array_key_exists('PHP_AUTH_USER', $_SERVER))
		{
			$this->userType = self::USER_TYPE_ANONYMOUS;
			return true;
		}

		// remove realm from user id
		$username = $this->removeRealm($_SERVER['PHP_AUTH_USER']);
		$password = $_SERVER['PHP_AUTH_PW'];

		$this->userType = $this->getUserType($username);
		switch ($this->userType)
		{
			case self::USER_TYPE_GUEST:
				$result = Kontaktua::checkKontaktuaPassword($username, $password);
				if ($result)
					$this->user = $this->getGuestUser($username);
				break;

			case self::USER_TYPE_USER:
				$result = myUser::checkLdapOrGuardPassword($username, $password);
				if ($result)
					$this->user = Doctrine_Core::getTable('Langilea')->findOneByUsername($username);
				break;

			default:
				throw new Exception('Invalid credentials', HttpErrors::INVALID_CREDENTIALS);
		}

		return $result;
	}

	private function addRealm($id)
	{
		if (strpos($id, '@') !== false)
			return $id;

		$realm = sfConfig::get('gerkud_api_realm');
		if (empty($realm))
			return $id;

		return sprintf('%s@%s', $id, $realm);
	}

	private function removeRealm($id)
	{
		$realm = sfConfig::get('gerkud_api_realm');
		if (empty($realm))
			return $id;

		return str_replace('@' . $realm, '', $id);
	}

	private function getUserType($id)
	{
		if (is_numeric($id))
			return self::USER_TYPE_GUEST;
		else
			return self::USER_TYPE_USER;
	}

	private function getNextPath()
	{
		$next = urldecode(array_shift($this->path));
		if (empty($next))
			return NULL;

		return $next;
	}

	private function dateConvert($date)
	{
		$dateObject = DateTime::createFromFormat(DateTime::ATOM, $date);

		$dateObject->setTimezone(new DateTimeZone(date_default_timezone_get()));

		return $dateObject->format(self::MYSQL_DATE_FORMAT);
	}

	private function dateToString($date)
	{
		return (new DateTime($date))->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d\TH:i:s\Z');
	}

	private function authUserId()
	{
		$authUserId = NULL;

		switch ($this->userType)
		{
			case self::USER_TYPE_ANONYMOUS:
				$authUserId = self::ANONYMOUS_USER_ID;
				break;
			case self::USER_TYPE_USER:
				$authUserId = $this->user->getUsername();
				break;
			case self::USER_TYPE_GUEST:
				$authUserId = $this->user->getId();
				break;
		}

		return $authUserId;
	}

	private function checkPermissions($data)
	{
		$authUserId = $this->authUserId();

		if (is_array($data) && array_key_exists('user', $data))
			$objectUser = $data['user'];
		if (is_object($data) && property_exists($data, 'user'))
			$objectUser = $data->user;
		else
			$objectUser = $authUserId;

		if ($this->addRealm($objectUser) != $this->addRealm($authUserId))
			return false;

		return true;
	}

	private function addIssue($jsonData)
	{
		$data = json_decode($jsonData, true);
		if ($data === NULL)
			throw new Exception('Invalid data format', HttpErrors::BAD_REQUEST);

		if (!array_key_exists('date', $data)
		 || !array_key_exists('location', $data)
		 || (!array_key_exists('messages', $data) && !array_key_exists('files', $data)))
			throw new Exception('Required fields missing', HttpErrors::BAD_REQUEST);

		if (!$this->checkPermissions($data))
			throw new Exception('Unauthorized', HttpErrors::FORBIDDEN);

		$gertakaria = $this->findDuplicateIssue($data);
		if ($gertakaria !== NULL)
			return $this->updateIssue($gertakaria->getId(), $jsonData);

		$gertakaria = new Gertakaria();

		$gertakaria->setHerritarrena(APIVersion::V3);

		$gertakaria->setCreatedAt($this->dateConvert($data['date']));

		$mota = sfConfig::get('gerkud_api_mota_id');
		if ($mota !== NULL)
			$gertakaria->setMotaId($mota);

		$klasea = sfConfig::get('gerkud_api_klasea_id');
		if ($klasea !== NULL)
			$gertakaria->setKlaseaId($klasea);

		$gertakaria->save();

		$gertakaria->setLangilea(NULL);
		if ($this->userType === self::USER_TYPE_USER)
			$gertakaria->setLangilea($this->user);
		else if ($this->userType === self::USER_TYPE_GUEST)
			$this->setContactInfo($data, $gertakaria);

		$gertakaria->save();

		$this->parseIssueMessages($data, $gertakaria);

		$this->parseIssueLocation($data, $gertakaria);

		$this->parseIssueFiles($data, $gertakaria);

		$gertakaria->save();

		return $gertakaria->getId();
	}

	private function updateIssue($id, $jsonData)
	{
		$data = json_decode($jsonData, true);
		if ($data === NULL)
			throw new Exception('Invalid data format', HttpErrors::BAD_REQUEST);

		$gertakaria = Doctrine_Core::getTable('gertakaria')->findOneById($id);
		if (!$gertakaria)
			throw new Exception('Issue not found', HttpErrors::NOT_FOUND);

		if (!$this->checkPermissions($data))
			throw new Exception('Unauthorized', HttpErrors::FORBIDDEN);

		$this->parseIssueMessages($data, $gertakaria);

		$this->parseIssueFiles($data, $gertakaria);

		return $gertakaria->getId();
	}

	private function parseUsers(&$result)
	{
		$id = $this->getNextPath();
		switch ($id)
		{
			case NULL:
				if ($this->request->getMethod() !== 'POST')
					throw new Exception('Method not implemented', HttpErrors::METHOD_NOT_ALLOWED);

				if ($this->request->getContentType() !== 'application/json')
					throw new Exception('Invalid data format', HttpErrors::BAD_REQUEST);

				$userId = $this->addUser($this->request->getContent());
				$result = $this->getUser($userId);

				$this->response->setStatusCode(HttpCodes::CREATED);
				$this->response->setHttpHeader('Location', $this->request->getPathInfo() . $userId);

				break;

			default:
				$this->parseUsersId($result, $id);
				break;
		}
	}

	private function parseUsersId(&$result, $id)
	{
		// remove realm from user id
		$id = $this->removeRealm($id);

		if ($this->getNextPath() !== NULL)
			throw new Exception('Method not implemented', HttpErrors::METHOD_NOT_ALLOWED);

		if ($this->authUserId() !== $id)
			throw new Exception('Unauthorized|' . $this->authUserId() . '|' . $id, HttpErrors::FORBIDDEN);

		switch ($this->request->getMethod())
		{
			case 'PATCH':
			case 'POST':
				if ($this->request->getContentType() !== 'application/json'
				 && $this->request->getContentType() !== 'application/merge-patch+json')
					throw new Exception('Invalid data format', HttpErrors::BAD_REQUEST);

				$userId = $this->updateUser($id, $this->request->getContent());
				$result = $this->getUser($userId);

				break;
			case 'GET':
			case 'HEAD':
				$result = $this->getUser($id);

				break;
			default:
				throw new Exception('Method not implemented', HttpErrors::METHOD_NOT_ALLOWED);
		}
	}

	private function addUser($jsonData)
	{
		$data = json_decode($jsonData, true);
		if ($data === NULL)
			throw new Exception('Invalid data format', HttpErrors::BAD_REQUEST);

		if (!array_key_exists('password', $data))
			throw new Exception('Required fields missing', HttpErrors::BAD_REQUEST);

		$kontaktua = $this->findDuplicateUser($data);
		if ($kontaktua === NULL)
		{
			$kontaktua = new Kontaktua();
			$kontaktua->save();
		}

		return $this->updateUser($kontaktua->getId(), $jsonData);
	}

	private function updateUser($id, $jsonData)
	{
		$data = json_decode($jsonData, true);
		if ($data === NULL)
			throw new Exception('Invalid data format', HttpErrors::BAD_REQUEST);

		$kontaktua = Doctrine_Core::getTable('kontaktua')->findOneById($id);
		if (!$kontaktua)
			throw new Exception('User not found', HttpErrors::NOT_FOUND);

		if (array_key_exists('fullname', $data))
			$kontaktua->setIzena($data['fullname']);
		if (array_key_exists('surnames', $data))
			$kontaktua->setAbizenak($data['surnames']);
		if (array_key_exists('phone', $data))
			$kontaktua->setTelefonoa($data['phone']);
		if (array_key_exists('mail', $data))
			$kontaktua->setPosta($data['mail']);
		if (array_key_exists('nid', $data))
			$kontaktua->setNAN($data['nid']);

		if (array_key_exists('notify', $data))
		{
			if ($data['notify'])
				$kontaktua->setOhartarazi(horkonponActions::OHARTARAZI_POSTA);
			else
				$kontaktua->setOhartarazi(horkonponActions::OHARTARAZI_EZ);
		}

		if (array_key_exists('language', $data))
			$kontaktua->setHizkuntza($data['language']);

		if (array_key_exists('password', $data))
			$kontaktua->setPassword($data['password']);

		$kontaktua->save();

		return $kontaktua->getId();
	}

	private function setContactInfo($data, &$gertakaria)
	{
		if ($this->user === NULL)
			return;

		$gertakaria->setKontaktua($this->user);

		$erabiltzaileDatuak = array();

		if ($this->user->getIzena())
			array_push($erabiltzaileDatuak, $this->user->getIzena());
		if ($this->user->getTelefonoa())
			array_push($erabiltzaileDatuak, $this->user->getTelefonoa());
		if ($this->user->getPosta())
			array_push($erabiltzaileDatuak, $this->user->getPosta());

		if (count($erabiltzaileDatuak) > 0)
			$gertakaria->setAbisuaNork(implode(', ', $erabiltzaileDatuak));
	}

	private function ping()
	{
		$this->response->setContentType('text/plain');
		$this->response->setHttpHeader('Cache-Control', 'no-cache');
		$this->response->setContent('pong');
		$this->response->send();
	}

	private function parseIssueMessages($data, &$gertakaria)
	{
		if (!array_key_exists('messages', $data))
			return;

		foreach ($data['messages'] as $message)
		{
			if (!$this->checkPermissions($message))
				throw new Exception('Unauthorized', HttpErrors::FORBIDDEN);

			if ($this->findDuplicateMessage($message, $gertakaria) !== NULL)
				continue;

			$iruzkina = new Iruzkina();
			$iruzkina->setGertakaria($gertakaria);
			if ($this->userType === self::USER_TYPE_USER)
				$iruzkina->setLangilea($this->user);
			$iruzkina->setEkintzaId(1); // iruzkina
			$iruzkina->setCreatedAt($this->dateConvert($message['date']));
			$iruzkina->setUpdatedAt($this->dateConvert($message['date']));
			$iruzkina->setTestua($message['text']);
			$iruzkina->setPublikoa(true);
			$iruzkina->save();

			if ($gertakaria->getLaburpena() === NULL)
			{
				$gertakaria->setLaburpena(substr($message['text'], 0, 100));
				// gorde hurrengo iruzkina gordetzerakoan datua ez galtzeko
				$gertakaria->save();
			}

			if ($gertakaria->getDeskribapena() === NULL)
			{
				$gertakaria->setDeskribapena($message['text']);
				// gorde hurrengo iruzkina gordetzerakoan datua ez galtzeko
				$gertakaria->save();
			}
		}
	}

	private function parseIssueFiles($data, &$gertakaria)
	{
		if (!array_key_exists('files', $data))
			return;

		foreach ($data['files'] as $file)
		{
			if (!$this->checkPermissions($file))
				throw new Exception('Unauthorized', HttpErrors::FORBIDDEN);

			if ($this->findDuplicateFile($file, $gertakaria) !== NULL)
				continue;

			$fitxategia = new Fitxategia();
			$fitxategia->setGertakaria($gertakaria);
			$fitxategia->setCreatedAt($this->dateConvert($file['date']));
			$fitxategia->setUpdatedAt($this->dateConvert($file['date']));
			$fitxategia->setFitxategia($file['filename']);
			$fitxategia->setEdukia($file['content']);
			if ($this->userType === self::USER_TYPE_USER)
				$fitxategia->setLangilea($this->user);
			$fitxategia->save();
		}
	}

	private function parseIssueLocation($data, &$gertakaria)
	{
		if (!array_key_exists('location', $data))
			return;

		$location = $data['location'];

		$this->parseIssueGPS($location, $gertakaria);
		$this->parseIssueAddress($location, $gertakaria);
	}

	private function parseIssueGPS($data, &$gertakaria)
	{
		if (!array_key_exists('gps', $data))
			return;

		$gps = $data['gps'];

		$geo = new Geo();
		$geo->setGertakaria($gertakaria);
		$geo->setGeometriaId(self::GEOMETRIA_PUNTUA);
		$geo->setLatitudea($gps['latitude']);
		$geo->setLongitudea($gps['longitude']);
		$geo->setZehaztasuna($gps['accuracy']);

		if (array_key_exists('address', $data))
			$geo->setTestua(substr(sprintf('HorKonpon: %s', $data['address']), 0, 50));
		else
			$geo->setTestua('HorKonpon');

		$geo->save();
	}

	private function parseIssueAddress($data, &$gertakaria)
	{
		if (!array_key_exists('address', $data))
			return;

		$kalea = Doctrine_Core::getTable('Kalea')->getKaleaGoogle($data['address']);
		if ($kalea)
		{
			$gertakaria->setKalea($kalea);
			if ($kalea->getBarrutiaId())
				$gertakaria->setBarrutiaId($kalea->getBarrutiaId());
			if ($kalea->getAuzoaId())
				$gertakaria->setAuzoaId($kalea->getAuzoaId());
		}
	}

	private function findDuplicateIssue($data)
	{
		$issue = Doctrine_Core::getTable('gertakaria')->findOneBy('created_at', $this->dateConvert($data['date']));
		if (!$issue)
			return NULL;

		if (!$issue->getHerritarrena())
			return NULL;

		if (!$issue->getKoordenadak() !== 0 && array_key_exists('gps', $data))
		{
			$issueGPS = $issue->getKoordenadak()[0];

			if ($issueGPS->getLatitudea() !== $data['gps']['latitude'])
				return NULL;

			if ($issueGPS->getLongitudea() !== $data['gps']['longitude'])
				return NULL;
		}

		return $issue;
	}

	private function findDuplicateMessage($data, &$gertakaria)
	{
		foreach ($gertakaria->getIruzkina() as $message)
		{
			if ($message->getEkintzaId() != 1)
				continue;

			if ($message->getCreatedAt() == $this->dateConvert($data['date'])
			 && $message->getTestua() === $data['text'])
				return $message;
		}

		return NULL;
	}

	private function findDuplicateFile($data, &$gertakaria)
	{
		foreach ($gertakaria->getFitxategiak() as $file)
		{
			if ($file->getCreatedAt() == $this->dateConvert($data['date'])
			 && $file->getFitxategia() === $data['filename'])
				return $file;
		}

		return NULL;
	}

	private function getGuestUser($id)
	{
		$kontaktua = Doctrine_Core::getTable('kontaktua')->findOneBy('id', $id);
		if (!$kontaktua)
			return NULL;

		return $kontaktua;
	}

	private function findDuplicateUser($data)
	{
		if (!array_key_exists('mail', $data))
			return NULL;

		if (!array_key_exists('password', $data))
			return NULL;

		$kontaktuak = Doctrine_Core::getTable('kontaktua')->findBy('posta', $data['mail']);
		foreach ($kontaktuak as $kontaktua)
		{
			if (Kontaktua::checkKontaktuaPassword($kontaktua->getId(), $data['password']))
				return $kontaktua;
		}

		return NULL;
	}

	private function getUser($id)
	{
		$user = new stdClass();
		switch ($this->getUserType($id))
		{
			case self::USER_TYPE_GUEST:
				$kontaktua = Doctrine_Core::getTable('Kontaktua')->findOneById($id);
				if (!$kontaktua)
					throw new Exception('User not found', HttpErrors::NOT_FOUND);

				$user->id = $kontaktua->getId();
				if ($kontaktua->getIzena())
					$user->fullname = $kontaktua->getIzena();
				if ($kontaktua->getPosta())
					$user->mail = $kontaktua->getPosta();
				if ($kontaktua->getTelefonoa())
					$user->phone = $kontaktua->getTelefonoa();

				if ($kontaktua->getHizkuntza())
					$user->language = $kontaktua->getHizkuntza();

				$user->notify = $kontaktua->getOhartarazi() > 0;
				break;

			case self::USER_TYPE_USER:
				if ($this->userType === self::USER_TYPE_USER)
				{
					$langilea = Doctrine_Core::getTable('Langilea')->findOneByUsername($id);
					if (!$langilea)
						throw new Exception('User not found', HttpErrors::NOT_FOUND);

					$user->id = $langilea->getUsername();
					if ($langilea->getFirstName())
						$user->fullname = $langilea->getFirstName();
					if ($langilea->getEmailAddress())
						$user->mail = $langilea->getEmailAddress();
					$user->notify = $langilea->getOhartarazteaId() > 1;
				}
				else
				{
					$user->id = self::ENTITY_USER_ID;
					$user->fullname = sfConfig::get('gerkud_erakundea');
				}
				break;

			default:
				throw new Exception('User not found', HttpErrors::NOT_FOUND);
		}

		// add realm to user id
		$user->id = $this->addRealm($user->id);

		return $user;
	}

	private function getIssue($id)
	{
		$gertakaria = Doctrine_Core::getTable('gertakaria')->findOneById($id);
		if (!$gertakaria)
			throw new Exception('Issue not found', HttpErrors::NOT_FOUND);

		if ($gertakaria->getHerritarrena() != APIVersion::V3)
			throw new Exception('Unauthorized', HttpErrors::FORBIDDEN);

		$updateDate = new DateTime($gertakaria->getUpdatedAt());
		$updateDate->setTimezone(new DateTimeZone('GMT'));
		$this->response->setHttpHeader('Last-Modified', $updateDate->format('D, d M Y H:i:s') . ' GMT');

		if ($this->request->getMethod() === 'HEAD')
			return NULL;

		$sinceDate = NULL;
		$since = $this->request->getHttpHeader('If-Modified-Since');
		if ($since !== NULL)
			$sinceDate = new DateTime($since);

		if ($sinceDate > $updateDate)
		{
			$this->response->setStatusCode(HttpCodes::NOT_MODIFIED);
			return NULL;
		}

		$issue = new stdClass();
		$issue->id = $gertakaria->getId();
		$issue->date = $this->dateToString($gertakaria->getCreatedAt());

		$users = array();
		if ($gertakaria->getLangileaId() !== NULL)
		{
			$users[] = $this->getUser($gertakaria->getLangilea()->getUsername());
			$issue->user = end($users)->id;
		}
/*
		else if ($gertakaria->getKontaktuaId() !== NULL)
		{
			$users[] = $this->getUser($gertakaria->getKontaktua()->getId());
			$issue->user = end($users)->id;
		}
*/
		else
			$issue->user = self::ANONYMOUS_USER_ID;

		if (!$this->checkPermissions($issue))
			throw new Exception('Unauthorized', HttpErrors::FORBIDDEN);

		foreach ($gertakaria->getKoordenadak() as $puntua)
		{
			$location = new stdClass();
			$location->gps = new stdClass();
			$location->gps->latitude = $puntua->getLongitudea();
			$location->gps->longitude = $puntua->getLatitudea();
			$issue->location = $location;

			// API only allows a single location right now
			break;
		}

		$messages = array();
		foreach ($gertakaria->getIruzkina() as $iruzkina)
		{
			if ($iruzkina->getEkintzaId() != 1
			 || !$iruzkina->getPublikoa())
				continue;

			$message = new stdClass();
			$message->date = $this->dateToString($iruzkina->getCreatedAt());
			$message->text = $iruzkina->getTestua();
			if ($iruzkina->getLangileaId() !== NULL)
			{
				$users[] = $this->getUser($iruzkina->getLangilea()->getUsername());
				$message->user = end($users)->id;
			}
			else if (property_exists($issue, 'user'))
				$message->user = $issue->user;

			$messages[] = $message;
		}
		$issue->messages = $messages;

		$issue->users = array_unique($users, SORT_REGULAR);

		return $issue;
	}
}
?>