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

		if (sfConfig::get('app_gerkud_hizkuntzak') != null && !in_array($this->getCulture(), sfConfig::get('app_gerkud_hizkuntzak')))
			$this->setCulture(sfConfig::get('app_gerkud_hizkuntzak')[0]);
	}
}
