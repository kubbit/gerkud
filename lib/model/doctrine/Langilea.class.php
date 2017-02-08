<?php

/**
 * Langilea
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    gerkud
 * @subpackage model
 * @author     Pasaiako Udala
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Langilea extends BaseLangilea
{
	public function __toString()
	{
 		if (is_null($this->getId()))
			return '';

		if (sfConfig::get('gerkud_izena_eta_abizena'))
			return trim($this->getFirstName().' '.$this->getLastName());
		else
			return $this->getUsername();
	}
}
