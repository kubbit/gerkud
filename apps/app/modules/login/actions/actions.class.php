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
				$culture = $request->getPreferredCulture(array('eu', 'es'));
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
