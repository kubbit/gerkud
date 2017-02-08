<?php
/*
class myUser extends sfBasicSecurityUser
{
}
*/
/*
class myUser extends sfGuardSecurityUser
{
}
*/

class myUser extends bhLDAPAuthSecurityUser
{
	public function isFirstRequest($boolean = null)
	{
		if (is_null($boolean))
			return $this->getAttribute('first_request', true);

		$this->setAttribute('first_request', $boolean);
	}

	public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
	{
		parent::initialize($dispatcher, $storage, $options);

		if (sfConfig::get('gerkud_hizkuntzak_gaituak') != null && !in_array($this->getCulture(), sfConfig::get('gerkud_hizkuntzak_gaituak')))
			$this->setCulture(sfConfig::get('gerkud_hizkuntzak_gaituak')[0]);
	}

	public static function checkLdapOrGuardPassword($username, $password)
	{
		if (sfConfig::get('gerkud_ldap'))
			return bhLDAP::checkPassword($username, $password);
		else
		{
			$langileak = Doctrine_Core::getTable('langilea');
			$user = $langileak->retrieveByUsername($username);
			if (is_null($user))
				return false;

			return $user->checkPasswordByGuard($password);
		}
	}

	public function signIn($user, $remember = false, $con = null)
	{
		if (sfConfig::get('gerkud_ldap'))
			return parent::signIn($user, $remember, $con);
		else
			return sfGuardSecurityUser::signIn($user, $remember, $con);
	}
}
