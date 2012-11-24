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
}

