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
		->where('g.egoera_id = ?', 1);
	return $q;
    }
    public function getForLuceneQuery($query1)
    {
	if (!empty($query1))
	{
	  $query = $query1['librea']['text'];
	  $kodea = $query1['id']['text'];
     	  if ($kodea=='')
	  {
	    if ($query!='')
	    {
	  	  $hits = self::getLuceneIndex()->find($query);
		  $pks = array();
		  foreach ($hits as $hit)
		  {
	              $pks[] = $hit->pk;
		  }

		  if (empty($pks))
		  {
//			      return array();
			$q = $this->createQuery('j')
        	           ->where(0);    
		  }else 
		  {
		  $q = $this->createQuery('j')
		      ->whereIn('j.id', $pks)
		      ->orderBy('j.lehentasuna_id DESC, j.id DESC');
	//	      ->limit(20);
		  }
	    }else 
	    {
		  $q = $this->createQuery('j');
	    }

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
            $q->orderBy('j.lehentasuna_id DESC, j.id DESC');
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
		if (sfContext::getInstance()->getConfiguration()->getApplication()=='orokorra') 
		{
	            $q->andWhere('g.langilea_id = ?', $lang);
		}
                if ((sfContext::getInstance()->getConfiguration()->getApplication()=='zerbitzu') && !(empty($taldeakId)))
		{
		    $q->whereIn('g.saila_id', $taldeakId);
		} else if ((sfContext::getInstance()->getConfiguration()->getApplication()=='zerbitzu') && (empty($taldeakId)))
		{
		    $q->andWhere(0);
		}
	        $q->orderBy('g.lehentasuna_id DESC, g.id DESC');
		return $q;
	}
   }
}
