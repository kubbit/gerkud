<?php

/**
 * horkonpon actions.
 *
 * @package    gerkud
 * @subpackage horkonpon
 * @author     Kubbit Information Technology
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

include('v3.php');

abstract class HttpErrors
{
	const BAD_REQUEST = 400;
	const INVALID_CREDENTIALS = 401;
	const FORBIDDEN = 403;
	const NOT_FOUND = 404;
	const METHOD_NOT_ALLOWED = 405;
}

abstract class APIVersion
{
	const V1 = 1;
	const V2 = 2;
	const V3 = 3;
}

class horkonponActions extends sfActions
{
	const GEOMETRIA_PUNTUA = 1;
	const API_ERANTZUNA_ZUZENA = 0;
	const API_ERANTZUNA_ERROREA = -1;
	const API_AZKEN_BERTSIOA = 2;

	const OHARTARAZI_EZ = 0;
	const OHARTARAZI_POSTA = 1;

	private $erabiltzailea;

	public function executeIndex(sfWebRequest $request)
	{
		$erantzuna = array();

		$erantzuna['version'] = self::API_AZKEN_BERTSIOA;

		try
		{
			if (!$request->isMethod(sfRequest::POST))
				throw new Exception('Ez da informaziorik jaso');

			if ($request->getParameter('datuak') !== NULL)
				$json = $request->getParameter('datuak');
			else if ($request->getParameter('data') !== NULL)
				$json = $request->getParameter('data');
			else
				throw new Exception(sprintf('Ez da informaziorik jaso: %s', $json));

			$array = json_decode($json, true);
			if ($array === NULL)
				throw new Exception(sprintf('Mezua ez da zuzena: %s', $json));

			if (!$this->checkAuth($request))
				throw new Exception('Atzipena ukatuta');

			$this->gertakaria = new Gertakaria();
			$this->gertakaria->save();

			$mota = sfConfig::get('gerkud_api_mota_id');
			if ($mota !== NULL)
				$this->gertakaria->setMotaId($mota);

			$klasea = sfConfig::get('gerkud_api_klasea_id');
			if ($klasea !== NULL)
				$this->gertakaria->setKlaseaId($klasea);

			if (array_key_exists('bertsioa', $array))
				$bertsioa = $array['bertsioa'];
			else if (array_key_exists('version', $array))
				$bertsioa = $array['version'];
			else
				throw new Exception('Mezuaren bertsioa ez dago ezarrita');

			switch ($bertsioa)
			{
				case 1:
					$this->APIv1($request, $array);
					break;
				case 2:
				default:
					$this->APIv2($request, $array);
					break;
			}

			$this->gertakaria->save();

			$erantzuna['status'] = self::API_ERANTZUNA_ZUZENA;
			$erantzuna['message'] = sprintf('Bidalketa zuzena. Erreferentzia: %s.', $this->gertakaria->getId());
			$erantzuna['code'] = $this->gertakaria->getId();
		}
		catch (Exception $e)
		{
			$erantzuna['status'] = self::API_ERANTZUNA_ERROREA;
			$erantzuna['message'] = $e->getMessage();
		}

		echo json_encode($erantzuna);

		return;
	}

	private function checkAuth($request)
	{
		$this->erabiltzailea = NULL;
		$pasahitza = NULL;

		if (array_key_exists('PHP_AUTH_USER', $_SERVER))
		{
			$this->erabiltzailea = $_SERVER['PHP_AUTH_USER'];
			if (array_key_exists('PHP_AUTH_PW', $_SERVER))
				$pasahitza = $_SERVER['PHP_AUTH_PW'];
		}
		else if ($request->getParameter('pasahitza') !== NULL)
			$pasahitza = $request->getParameter('pasahitza');
		else if ($request->getParameter('key') !== NULL)
			$pasahitza = $request->getParameter('key');

		$confPasahitza = sfConfig::get('gerkud_api_pasahitza');
		if ($confPasahitza && $confPasahitza !== $pasahitza)
		{
			$this->erabiltzailea = NULL;
			return false;
		}

		return true;
	}


	private function APIv1(sfWebRequest $request, $array)
	{
		$this->gertakaria->setHerritarrena(APIVersion::V1);

		$erabiltzaileDatuak = array();
		if (array_key_exists('izena', $array))
			array_push($erabiltzaileDatuak, $array['izena']);
		if (array_key_exists('telefonoa', $array))
			array_push($erabiltzaileDatuak, $array['telefonoa']);
		if (array_key_exists('posta', $array))
			array_push($erabiltzaileDatuak, $array['posta']);

		$this->gertakaria->setAbisuaNork(implode(', ', $erabiltzaileDatuak));
		if (array_key_exists('oharrak', $array))
		{
			$this->gertakaria->setLaburpena(substr($array['oharrak'], 0, 100));
			$this->gertakaria->setDeskribapena($array['oharrak']);
		}

		$langilea = null;
		$this->gertakaria->setLangilea($langilea);

		if (count($erabiltzaileDatuak) > 0)
		{
			$kontaktua = new Kontaktua();
			$kontaktua->setIzena($array['izena']);
			$kontaktua->setPosta($array['posta']);
			$kontaktua->setTelefonoa($array['telefonoa']);

			if (array_key_exists('ohartarazi', $array) && $array['ohartarazi'])
				$kontaktua->setOhartarazi($array['ohartarazi']);

			if (array_key_exists('hizkuntza', $array))
				$kontaktua->setHizkuntza($array['hizkuntza']);

			$this->gertakaria->setKontaktua($kontaktua);
		}

		if (array_key_exists('gps', $array))
		{
			$this->geo = new Geo();
			$this->geo->setGertakaria($this->gertakaria);
			$this->geo->setGeometriaId(self::GEOMETRIA_PUNTUA);
			$this->geo->setLatitudea($array['gps']['latitudea']);
			$this->geo->setLongitudea($array['gps']['longitudea']);
			$this->geo->setZehaztasuna($array['gps']['zehaztasuna']);

			if (array_key_exists('helbidea', $array))
			{
				$this->geo->setTestua(substr($array['helbidea'], 0, 50));

				$kalea = Doctrine_Core::getTable('Kalea')->getKaleaGoogle($array['helbidea']);
				if ($kalea)
				{
					$this->gertakaria->setKalea($kalea);
					if ($kalea->getBarrutiaId())
						$this->gertakaria->setBarrutiaId($kalea->getBarrutiaId());
					if ($kalea->getAuzoaId())
						$this->gertakaria->setAuzoaId($kalea->getAuzoaId());
				}
			}

			$this->geo->save();
		}

		if (array_key_exists('argazkia', $array))
		{
			$this->fitxategia = new Fitxategia();
			$this->fitxategia->setGertakaria($this->gertakaria);
			$this->fitxategia->setFitxategia($array['argazkia']['izena']);
			$this->fitxategia->setEdukia($array['argazkia']['edukia']);
			$this->fitxategia->setLangilea($langilea);
			$this->fitxategia->save();
		}
	}

	private function APIv2(sfWebRequest $request, $mezua)
	{
		$this->gertakaria->setHerritarrena(APIVersion::V2);

		if (array_key_exists('date', $mezua))
			$this->gertakaria->setCreatedAt($mezua['date']);

		$langilea = null;
		if ($this->erabiltzailea !== null)
		{
			$langilea = Doctrine_Core::getTable('Langilea')->findOneByEmailAddress($this->erabiltzailea);
			if (!$langilea)
				$langilea = null;
		}

		$erabiltzaileDatuak = array();
		if (array_key_exists('user', $mezua))
		{
			$user = $mezua['user'];
			if (array_key_exists('fullname', $user))
				array_push($erabiltzaileDatuak, $user['fullname']);
			if (array_key_exists('phone', $user))
				array_push($erabiltzaileDatuak, $user['phone']);
			if (array_key_exists('mail', $user))
			{
				array_push($erabiltzaileDatuak, $user['mail']);

				if ($langilea === null)
				{
					$langilea = Doctrine_Core::getTable('Langilea')->findOneByEmailAddress($user['mail']);
					if (!$langilea)
						$langilea = null;
				}
			}

			if (count($erabiltzaileDatuak) > 0 && $langilea === null)
			{
				$kontaktua = new Kontaktua();
				if (array_key_exists('fullname', $user))
					$kontaktua->setIzena($user['fullname']);
				if (array_key_exists('surnames', $user))
					$kontaktua->setAbizenak($user['surnames']);
				if (array_key_exists('phone', $user))
					$kontaktua->setTelefonoa($user['phone']);
				if (array_key_exists('mail', $user))
					$kontaktua->setPosta($user['mail']);
				if (array_key_exists('nid', $user))
					$kontaktua->setNAN($user['nid']);

				if (array_key_exists('notify', $user))
				{
					if ($user['notify'])
						$kontaktua->setOhartarazi(self::OHARTARAZI_POSTA);
					else
						$kontaktua->setOhartarazi(self::OHARTARAZI_EZ);
				}

				if (array_key_exists('language', $user))
					$kontaktua->setHizkuntza($user['language']);

				$this->gertakaria->setKontaktua($kontaktua);
			}
		}

		$this->gertakaria->setAbisuaNork(implode(', ', $erabiltzaileDatuak));
		if (array_key_exists('comments', $mezua))
		{
			$this->gertakaria->setLaburpena(substr($mezua['comments'], 0, 100));
			$this->gertakaria->setDeskribapena($mezua['comments']);
		}

		$this->gertakaria->setLangilea($langilea);

		if (array_key_exists('gps', $mezua))
		{
			$gps = $mezua['gps'];

			$this->geo = new Geo();
			$this->geo->setGertakaria($this->gertakaria);
			$this->geo->setGeometriaId(self::GEOMETRIA_PUNTUA);
			$this->geo->setLatitudea($gps['latitude']);
			$this->geo->setLongitudea($gps['longitude']);
			$this->geo->setZehaztasuna($gps['accuracy']);

			if (array_key_exists('address', $mezua) && array_key_exists('address', $mezua['address']))
				$this->geo->setTestua(substr(sprintf('HorKonpon: %s', $mezua['address']['address']), 0, 50));
			else
				$this->geo->setTestua('HorKonpon');

			$this->geo->save();
		}

		if (array_key_exists('address', $mezua) && array_key_exists('address', $mezua['address']))
		{
			$kalea = Doctrine_Core::getTable('Kalea')->getKaleaGoogle($mezua['address']['address']);
			if ($kalea)
			{
				$this->gertakaria->setKalea($kalea);
				if ($kalea->getBarrutiaId())
					$this->gertakaria->setBarrutiaId($kalea->getBarrutiaId());
				if ($kalea->getAuzoaId())
					$this->gertakaria->setAuzoaId($kalea->getAuzoaId());
			}
		}

		if (array_key_exists('subtype', $mezua))
		{
			$this->gertakaria->setAzpimotaId($mezua['subtype']);

			$mota = $this->gertakaria->getAzpimota()->getMotaId();
			$this->gertakaria->setMotaId($mota);

			$sailaMota = Doctrine_Core::getTable('SailaMota')->findOneByMotaId($mota);
			if ($sailaMota !== null && $sailaMota->getSailaId() !== null)
			{
				$this->gertakaria->setSailaId($sailaMota->getSailaId());
				$this->gertakaria->setEgoeraId(2);
			}
		}

		if (array_key_exists('file', $mezua))
		{
			$file = $mezua['file'];

			$this->fitxategia = new Fitxategia();
			$this->fitxategia->setGertakaria($this->gertakaria);
			$this->fitxategia->setFitxategia($file['filename']);
			$this->fitxategia->setEdukia($file['content']);
			$this->fitxategia->setLangilea($langilea);
			$this->fitxategia->save();
		}
	}

	public function executeV3(sfWebRequest $request)
	{
		$result = array();

		$this->getResponse()->setContentType('application/json');

		try
		{
			$v3 = new v3();

			$v3->parseRequest($request, $this->getResponse(), $result);

			$result = json_encode($result, JSON_PRETTY_PRINT);
		}
		catch (Exception $e)
		{
			$this->getResponse()->setStatusCode(HttpErrors::BAD_REQUEST);

			if ($e->getCode() === HttpErrors::INVALID_CREDENTIALS)
				$this->getResponse()->setHttpHeader('WWW-Authenticate', 'Basic realm="API key"');

			$this->getResponse()->setStatusCode($e->getCode(), $e->getMessage());

			$result = null;
		}

		return $this->renderText($result);
	}
}
