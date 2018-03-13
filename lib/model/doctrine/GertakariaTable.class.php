<?php
class GertakariaTable extends Doctrine_Table
{
	const ERAKUTSI_DENAK = 'denak';
	const ERAKUTSI_SAILEKOAK = 'sailekoak';
	const ERAKUTSI_NEREAK = 'nereak';

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
		$ordenaketa = sfConfig::get('gerkud_ordenaketa_eskaerak');
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
		$taldeak = sfContext::getInstance()->getUser()->getguardUser()->getGroups();
		$taldeakId = Array();
		foreach ($taldeak as $taldea)
			array_push($taldeakId, $taldea->getId());

		if (!empty($query1))
		{
			$query = $query1['librea']['text'];
			$kodea = $query1['id']['text'];
			if ($kodea == '')
			{
				$q = $this->createQuery('j');
				if ($query != '')
					$q->where('j.laburpena LIKE :query OR j.deskribapena LIKE :query OR j.abisuaNork LIKE :query', array(':query' => '%' . $query . '%'));

				if (sfConfig::get('gerkud_api_saila_bakarrik'))
				{
					if (empty($taldeakId))
						$q->andWhere('(j.herritarrena IS NULL OR j.saila_id IS NULL)');
					else
						$q->andWhere(sprintf('(j.herritarrena IS NULL OR j.saila_id IS NOT NULL OR (j.herritarrena = 1 AND j.saila_id IN (%s)))', implode(',', $taldeakId)));
				}

				if ($query1['egoera_id']) $q->andWhere('j.egoera_id = :egoera', array(':egoera' => $query1['egoera_id']));
				if (array_key_exists('klasea_id', $query1) && $query1['klasea_id']) $q->andWhere('j.klasea_id = :klasea', array(':klasea' => $query1['klasea_id']));
				if (array_key_exists('mota_id', $query1) && $query1['mota_id']) $q->andWhere('j.mota_id = :mota', array(':mota' => $query1['mota_id']));
				if (array_key_exists('azpimota_id', $query1) && $query1['azpimota_id']) $q->andWhere('j.azpimota_id = :azpimota', array(':azpimota' => $query1['azpimota_id']));
				if ($query1['saila_id']) $q->andWhere('j.saila_id = :saila', array(':saila' => $query1['saila_id']));
				if (array_key_exists('barrutia_id', $query1) && $query1['barrutia_id']) $q->andWhere('j.barrutia_id = :barrutia', array(':barrutia' => $query1['barrutia_id']));
				if (array_key_exists('auzoa_id', $query1) && $query1['auzoa_id']) $q->andWhere('j.auzoa_id = :auzoa', array(':auzoa' => $query1['auzoa_id']));
				if (array_key_exists('kalea_id', $query1) && $query1['kalea_id']) $q->andWhere('j.kalea_id = :kalea', array(':kalea' => $query1['kalea_id']));
				if (array_key_exists('kale_zbkia', $query1) && $query1['kale_zbkia']['text']) $q->andWhere('j.kale_zbkia = :zbkia', array(':zbkia' => $query1['kale_zbkia']['text']));
				if (array_key_exists('jatorrizkoSaila_id', $query1) && $query1['jatorrizkoSaila_id']) $q->andWhere('j.jatorrizkosaila_id = :jatorrizkosaila', array(':jatorrizkosaila' => $query1['jatorrizkoSaila_id']));
				if (array_key_exists('espedientea', $query1) && $query1['espedientea']['text']) $q->andWhere('j.espedientea = :espedientea', array(':espedientea' => $query1['espedientea']['text']));
				if (array_key_exists('eraikina_id', $query1) && $query1['eraikina_id']) $q->andWhere('j.eraikina_id = :eraikina', array(':eraikina' => $query1['eraikina_id']));

				if ($query1['created_at_noiztik'])
					$q->andWhere('j.created_at >= :created_at1', array(':created_at1' => $query1['created_at_noiztik']));
				if ($query1['created_at_nora'])
					$q->andWhere('j.created_at <= :created_at2', array(':created_at2' => $query1['created_at_nora']));

				if ($query1['ixte_data_noiztik'])
					$q->andWhere('j.ixte_data >= :ixte_data1', array(':ixte_data1' => $query1['ixte_data_noiztik']));
				if ($query1['ixte_data_nora'])
					$q->andWhere('j.ixte_data <= :ixte_data2', array(':ixte_data2' => $query1['ixte_data_nora']));
			}
			else
			{
				$q = $this->createQuery('j')
					->Where('j.id = :id', array(':id' => $kodea));
			}
		}
		else
		{
			$lang = sfContext::getInstance()->getUser()->getguardUser()->getId();

			$where = 'j.egoera_id NOT IN (5, 1, 6)';

			if (sfConfig::get('gerkud_api_saila_bakarrik'))
			{
				if (empty($taldeakId))
					$where .= ' AND (j.herritarrena IS NULL OR j.saila_id IS NULL)';
				else
					$where .= sprintf(' AND (j.herritarrena IS NULL OR j.saila_id IS NOT NULL OR (j.herritarrena = 1 AND j.saila_id IN (%s)))', implode(',', $taldeakId));
			}

			$eskubideak = Array();
			if (sfContext::getInstance()->getUser()->hasCredential('admins'))
				$eskubideak = array_merge($eskubideak, sfConfig::get('gerkud_gertakariak_erakutsi_admins'));
			if (sfContext::getInstance()->getUser()->hasCredential('gerkud'))
				$eskubideak = array_merge($eskubideak, sfConfig::get('gerkud_gertakariak_erakutsi_gerkud'));
			if (sfContext::getInstance()->getUser()->hasCredential('zerbitzu'))
				$eskubideak = array_merge($eskubideak, sfConfig::get('gerkud_gertakariak_erakutsi_zerbitzu'));
			if (sfContext::getInstance()->getUser()->hasCredential('arrunta'))
				$eskubideak = array_merge($eskubideak, sfConfig::get('gerkud_gertakariak_erakutsi_arrunta'));

			if (!empty($eskubideak))
				$where .= $this->getIragazkiak($eskubideak, $taldeakId, false);

			$q = Doctrine_Query::create()
			 ->from('gertakaria j')
			 ->where($where, array(
			 ':lang' => $lang
			 ));
		}

		$ordenaketa = sfConfig::get('gerkud_ordenaketa_gertakariak');
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

	private function getIragazkiak($ezarpenak, $taldeakId)
	{
		$where = '';

		if (in_array(self::ERAKUTSI_DENAK, $ezarpenak))
			return $where;

		if (in_array(self::ERAKUTSI_SAILEKOAK, $ezarpenak) && !(empty($taldeakId)))
			$where .= 'j.saila_id IN ( ' . implode(',', $taldeakId) . ' )';

		if (in_array(self::ERAKUTSI_NEREAK, $ezarpenak) && !(empty($taldeakId)))
		{
			if ($where !== '')
				$where .= ' OR ';
			$where .= 'j.langilea_id = :lang';
		}

		if ($where === '')
			$where .= ' j.id IS NULL';

		return ' AND (' . $where . ')';
	}
}
