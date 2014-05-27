<?php

/**
 * erroreak actions.
 *
 * @package    gerkud
 * @subpackage erroreak
 * @author     Kubbit Information Technology
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

class erroreakActions extends sfActions
{
	public function executeError(sfWebRequest $request)
	{
		$this->testua = '';

		switch ($this->getResponse()->getStatusCode())
		{
			case 404:
				$this->testua = __('Ezin izan da eskatutako orria aurkitu.');
				break;
			default:
				$this->testua = __('Errorea aplikazioan. Administratzailearekin harremanetan jarri.');
				break;
		}
	}
}
