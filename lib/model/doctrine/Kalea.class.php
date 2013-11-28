<?php

/**
 * Kalea
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    gerkud
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Kalea extends BaseKalea
{
	public function __toString()
	{
		if (!is_null($this->getId()))
			return $this->getIzena();
		else
			return '';
	}

	public function getKaleas()
	{
		$q = Doctrine_Query::create()
			->from('Kalea k')
			->orderBy('Izena');

		return $q->execute();
	}
}
