<?php

class KaleaTable extends Doctrine_Table
{
	public static function getInstance()
	{
		return Doctrine_Core::getTable('Kalea');
	}

	public static function getKaleaGoogle($izena)
	{
		$q = Doctrine_Query::create()->from('Kalea k')->addWhere('lower(k.google) LIKE lower(?)', $izena);
		$kaleak = $q->execute()->toArray();

		if (count($kaleak) == 0)
			return null;

		$kalea = $kaleak[0];
		return Doctrine_Core::getTable('Kalea')->find($kalea['id']);
	}
}
