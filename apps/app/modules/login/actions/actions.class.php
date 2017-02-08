<?php

require_once(sfConfig::get('sf_plugins_dir') . '/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');
require_once(sfConfig::get('sf_plugins_dir') . '/bhLDAPAuthPlugin/modules/bhLDAPAuth/actions/actions.class.php');

class loginActions extends bhLDAPAuthActions
{
	public function executeSignin($request)
	{
		// 'beharrezkoa' balidazioa ez erakusteko login pantailan
		sfValidatorBase::setDefaultMessage('required', ' ');

		if (!$request->getParameter('sf_culture'))
		{
			if ($this->getUser()->isFirstRequest())
			{
				$cultures = sfConfig::get('gerkud_hizkuntzak_gaituak');
				if ($cultures === null)
					$cultures = array('eu', 'es');

				$culture = $request->getPreferredCulture($cultures);
				$this->getUser()->setCulture($culture);
				$this->getUser()->isFirstRequest(false);
			}
			else
			{
				$culture = $this->getUser()->getCulture();
			}
		}
		if (sfConfig::get('gerkud_ldap'))
			bhLDAPAuthActions::executeSignin($request);
		else
			BasesfGuardAuthActions::executeSignin($request);
	}

	public function executeSecure($request)
	{
		if (sfConfig::get('gerkud_ldap'))
			bhLDAPAuthActions::executeSecure($request);
		else
			BasesfGuardAuthActions::executeSecure($request);
	}
}
