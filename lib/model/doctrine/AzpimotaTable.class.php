<?php

class AzpimotaTable extends Doctrine_Table
{
	public static function getInstance()
	{
		return Doctrine_Core::getTable('Azpimota');
	}

	public function getAzpimotaQuery($refValue)
	{
		return $this->createQuery('a')->select('a.id, t.izena')
			->leftJoin('a.Translation t WITH t.lang = ?', sfContext::getInstance()->getUser()->getCulture())
			//->where('a.mota_id = ?', $refValue)
			->orderBy('t.izena ASC');
	}
}