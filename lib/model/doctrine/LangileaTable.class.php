<?php

class LangileaTable extends sfGuardUserTable
{
	public static function getInstance()
	{
		return Doctrine_Core::getTable('Langilea');
	}
}