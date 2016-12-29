<?php

require_once(sfConfig::get('sf_plugins_dir') . '/bhLDAPAuthPlugin/modules/bhLDAPAuth/actions/actions.class.php');

class loginActions extends bhLDAPAuthActions
{
	public function executeSignin($request)
	{
		if (!$request->getParameter('sf_culture'))
		{
			if ($this->getUser()->isFirstRequest())
			{
				$cultures = sfConfig::get('app_gerkud_hizkuntzak');
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

		parent::executeSignin($request);
	}
}
