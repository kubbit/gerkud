<?php
class GertakariaTable extends Doctrine_Table
{
	public static function getGertakaria($id)
	{
		$q = Doctrine_Query::create()
			->from('gertakaria g')
			->where('g.id = ?', $id);
		return $q;
	}

	public static function getInstance()
	{
		return Doctrine_Core::getTable('Gertakaria');
	}

	public function getEskaerak()
	{
		$ordenaketa = sfConfig::get('app_ordenaketa_eskaerak');
		$q = Doctrine_Query::create()
			->from('gertakaria j')
			->where('j.egoera_id = ?', 1);
		if ($ordenaketa && count($ordenaketa) > 0)
		{
			$q->orderBy(implode(', ', $ordenaketa));
			return $q;
		}
		else
		{
			return $q;
		}
	}

	public function getEskaeraKopurua()
	{
		$q = $this->createQuery('j')
			->select('count(*)')
			->from('gertakaria g')
			->where('g.egoera_id = ?', 1);
		return $q->fetchOne(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
	}

	public function getBilaketaEmaitzak($query1)
	{
		if (!empty($query1))
		{
			$query = $query1['librea']['text'];
			$kodea = $query1['id']['text'];
			if ($kodea == '')
			{
				$q = $this->createQuery('j');
				if ($query != '')
					$q->where('j.laburpena LIKE :query OR j.deskribapena LIKE :query OR j.abisuaNork LIKE :query', array(':query' => '%' . $query . '%'));

				if ($query1['egoera_id']) $q->andWhere('j.egoera_id = ?', $query1['egoera_id']);
				if (array_key_exists('klasea_id', $query1) && $query1['klasea_id']) $q->andWhere('j.klasea_id = ?', $query1['klasea_id']);
				if (array_key_exists('mota_id', $query1) && $query1['mota_id']) $q->andWhere('j.mota_id = ?', $query1['mota_id']);
				if (array_key_exists('azpimota_id', $query1) && $query1['azpimota_id']) $q->andWhere('j.azpimota_id = ?', $query1['azpimota_id']);
				if ($query1['saila_id']) $q->andWhere('j.saila_id = ?', $query1['saila_id']);
				if (array_key_exists('barrutia_id', $query1) && $query1['barrutia_id']) $q->andWhere('j.barrutia_id = ?', $query1['barrutia_id']);
				if (array_key_exists('auzoa_id', $query1) && $query1['auzoa_id']) $q->andWhere('j.auzoa_id = ?', $query1['auzoa_id']);
				if (array_key_exists('kalea_id', $query1) && $query1['kalea_id']) $q->andWhere('j.kalea_id = ?', $query1['kalea_id']);
				if (array_key_exists('kale_zbkia', $query1) && $query1['kale_zbkia']['text']) $q->andWhere('j.kale_zbkia = ?', $query1['kale_zbkia']['text']);
				if (array_key_exists('jatorrizkoSaila_id', $query1) && $query1['jatorrizkoSaila_id']) $q->andWhere('j.jatorrizkosaila_id = ?', $query1['jatorrizkoSaila_id']);
				if (array_key_exists('eraikina_id', $query1) && $query1['eraikina_id']) $q->andWhere('j.eraikina_id = ?', $query1['eraikina_id']);

				if ($query1['created_at_noiztik'])
					$q->andWhere('j.created_at >= ?', $query1['created_at_noiztik']);
				if ($query1['created_at_nora'])
					$q->andWhere('j.created_at <= ?', $query1['created_at_nora']);

				if ($query1['ixte_data_noiztik'])
					$q->andWhere('j.ixte_data >= ?', $query1['ixte_data_noiztik']);
				if ($query1['ixte_data_nora'])
					$q->andWhere('j.ixte_data <= ?', $query1['ixte_data_nora']);
			}
			else
			{
				$q = $this->createQuery('j')
					->Where('j.id = ?', $kodea);
			}
		}
		else
		{
			$lang = sfContext::getInstance()->getUser()->getguardUser()->getId();
			$taldeak = sfContext::getInstance()->getUser()->getguardUser()->getGroups();
			$taldeakId = Array();
			foreach ($taldeak as $taldea)
			{
				array_push($taldeakId, $taldea->getId());
			}

			$where = 'j.egoera_id NOT IN (5, 1, 6)';

			if (sfContext::getInstance()->getUser()->hasCredential(array('admins', 'gerkud'), false))
				/* no añadir mas filtros */;
			else if (sfContext::getInstance()->getUser()->hasCredential('zerbitzu') && !(empty($taldeakId)))
				$where .= ' AND (j.saila_id IN ( ' . implode(',',$taldeakId) . ' ) OR j.langilea_id = :lang)';
			else if (sfContext::getInstance()->getUser()->hasCredential('arrunta'))
				$where .= ' AND j.langilea_id = :lang';

			$q = Doctrine_Query::create()
			 ->from('gertakaria j')
			 ->where($where, array(
			 ':lang' => $lang
			 ));
		}

		$ordenaketa = sfConfig::get('app_ordenaketa_gertakariak');
		if ($ordenaketa && count($ordenaketa) > 0)
		{
			$q->orderBy(implode(', ', $ordenaketa));
			return $q;
		}
		else
		{
			return $q;
		}
	}
}
