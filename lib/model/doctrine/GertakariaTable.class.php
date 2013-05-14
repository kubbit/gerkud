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

    public function getLuceneIndex()
    {
	ProjectConfiguration::registerZend();

//	if (file_exists($index = $this->getLuceneIndexFile()))
	if (file_exists($index = sfConfig::get('sf_data_dir').'/zend/gertakaria.index'))
	{
	    return Zend_Search_Lucene::open($index);
	} else
	{
	    return Zend_Search_Lucene::create($index);
	}
    }

    public function getLuceneIndexFile()
    {
#	  return sfConfig::get('sf_data_dir').'/gertakaria.'.sfConfig::get('sf_environment').'.index';
          return sfConfig::get('sf_data_dir').'/zend/gertakaria.index';
    }

    public function getEskaerak()
    {
	$q = $this->createQuery('j')
        	->from('gertakaria g')
		->where('g.egoera_id = ?', 1)
		->orderBy('created_at DESC');
	return $q;
    }
    public function getEskaeraKopurua()
    {
	$q = $this->createQuery('j')
		->select('count(*)')
        	->from('gertakaria g')
		->where('g.egoera_id = ?', 1);
	return $q->fetchOne(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
    }

    public function getForLuceneQuery($query1)
    {
	if (!empty($query1))
	{
	  $query = $query1['librea']['text'];
	  $kodea = $query1['id']['text'];
     	  if ($kodea=='')
	  {
	    $q = $this->createQuery('j');
	    if ($query!='')
		    $q->where('j.laburpena LIKE :query OR j.deskribapena LIKE :query', array(':query' => '%' . $query . '%'));

	    if ($query1['egoera_id']) $q->andWhere('j.egoera_id = ?', $query1['egoera_id']);
            if ($query1['klasea_id']) $q->andWhere('j.klasea_id = ?', $query1['klasea_id']);
	    if ($query1['mota_id']) $q->andWhere('j.mota_id = ?', $query1['mota_id']);
            if ($query1['azpimota_id']) $q->andWhere('j.azpimota_id = ?', $query1['azpimota_id']);
            if ($query1['saila_id']) $q->andWhere('j.saila_id = ?', $query1['saila_id']);
	    if ($query1['barrutia_id']) $q->andWhere('j.barrutia_id = ?', $query1['barrutia_id']);
	    if ($query1['kalea_id']) $q->andWhere('j.kalea_id = ?', $query1['kalea_id']);
	    if ($query1['kale_zbkia']['text']) $q->andWhere('j.kale_zbkia = ?', $query1['kale_zbkia']['text']);
            if ($query1['jatorrizkoSaila_id']) $q->andWhere('j.jatorrizkosaila_id = ?', $query1['jatorrizkoSaila_id']);
            if ($query1['eraikina_id']) $q->andWhere('j.eraikina_id = ?', $query1['eraikina_id']);

	    if ($query1['created_at_noiztik']['year'])
	    {
		    $noiztik = sprintf('%04d-%02d-%02d', $query1['created_at_noiztik']['year'], $query1['created_at_noiztik']['month'], $query1['created_at_noiztik']['day']);
		    $q->andWhere('j.created_at >= ?', $noiztik);
	    }
	    if ($query1['created_at_nora']['year'])
	    {
		    $noiztik = sprintf('%04d-%02d-%02d', $query1['created_at_nora']['year'], $query1['created_at_nora']['month'], $query1['created_at_nora']['day']);
		    $q->andWhere('j.created_at <= ?', $noiztik);
	    }

	    if ($query1['ixte_data_noiztik']['year'])
	    {
		    $noiztik = sprintf('%04d-%02d-%02d', $query1['ixte_data_noiztik']['year'], $query1['ixte_data_noiztik']['month'], $query1['ixte_data_noiztik']['day']);
		    $q->andWhere('j.ixte_data >= ?', $noiztik);
	    }
	    if ($query1['ixte_data_nora']['year'])
	    {
		    $noiztik = sprintf('%04d-%02d-%02d', $query1['ixte_data_nora']['year'], $query1['ixte_data_nora']['month'], $query1['ixte_data_nora']['day']);
		    $q->andWhere('j.ixte_data <= ?', $noiztik);
	    }

            $q->orderBy('j.created_at DESC');
	    return $q;

   	  } else
   	  {
		  $q = $this->createQuery('j')
		  ->Where('j.id = ?', $kodea);
                  return $q;
	  }
	} else
	{
		$lang=sfContext::getInstance()->getUser()->getguardUser()->getId();
                $taldeak=sfContext::getInstance()->getUser()->getguardUser()->getGroups();
		$taldeakId=Array();
		foreach ($taldeak as $taldea)
		{
			array_push ($taldeakId,$taldea->getId());
		}
	        $q = Doctrine_Query::create()
        	    ->from('gertakaria g')
	            ->where('g.egoera_id != ?', 5)
                    ->andWhere('g.egoera_id != ?', 1)
        	    ->andWhere('g.egoera_id != ?', 6);
		if (sfContext::getInstance()->getUser()->hasCredential(array('admins', 'gerkud'), false))
				/* no añadir mas filtros */;
		else if (sfContext::getInstance()->getUser()->hasCredential('zerbitzu') && !(empty($taldeakId)))
		        $q->whereIn('g.saila_id', $taldeakId);
		else if (sfContext::getInstance()->getUser()->hasCredential('zerbitzu') && (empty($taldeakId)))
		        $q->andWhere(0);
		else if (sfContext::getInstance()->getUser()->hasCredential('arrunta'))
	            $q->andWhere('g.langilea_id = ?', $lang);

	        $q->orderBy('g.created_at DESC');
		return $q;
	}
   }
}
