<?php

/**
 * Kontaktua
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    gerkud
 * @subpackage model
 * @author     Pasaiako Udala
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Kontaktua extends BaseKontaktua
{
	public function __toString()
	{
		$izena = array();
		$datuak = array();

		if (!empty($this->getIzena()))
			$izena[] = $this->getIzena();
		if (!empty($this->getAbizenak()))
			$izena[] = $this->getAbizenak();

		if (sizeof($izena) > 0)
			$datuak[] = implode(' ', $izena);

		if (!empty($this->getTelefonoa()))
			$datuak[] = $this->getTelefonoa();
		if (!empty($this->getPosta()))
			$datuak[] = $this->getPosta();
		if (!empty($this->getNan()))
			$datuak[] = $this->getNan();

		return implode('; ', $datuak);
	}

	public function has_data()
	{
		if (is_null($this->getId()))
			return false;

		if (!empty($this->getIzena()))
			return true;

		if (!empty($this->getAbizenak()))
			return true;

		if (!empty($this->getTelefonoa()))
			return true;

		if (!empty($this->getPosta()))
			return true;

		if (!empty($this->getNan()))
			return true;

		return false;
	}

	public static function checkKontaktuaPassword($id, $pass)
	{
		$kontaktua = Doctrine_Core::getTable('Kontaktua')->findOneBy('id', $id);
		if (!$kontaktua)
			return false;

		return $kontaktua->checkPassword($pass);
	}

	public function checkPassword($pass)
	{
		if ($this->pasahitza === NULL)
			return false;

		return password_verify($pass, $this->pasahitza);
	}

	public function setPassword($value)
	{
		if ($value === NULL || strlen($value) === 0)
			throw new Exception('Password cannot be empty.');

		$this->setPasahitza(password_hash($value, PASSWORD_BCRYPT));
	}
}
