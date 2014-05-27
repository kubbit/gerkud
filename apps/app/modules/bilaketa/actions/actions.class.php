<?php

/**
 * bilaketa actions.
 *
 * @package    gerkud
 * @subpackage bilaketa
 * @author     Kubbit Information Technology (http://kubbit.com)
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bilaketaActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->erroreak = false;

		$this->filter = new GertakariaFormFilter();

		if (!$request->isMethod('post'))
			return;

		$this->processBilaketa($request, $this->filter);

		if ($this->erroreak)
			return;

		$this->forward('gertakaria', 'index');
	}

	protected function processBilaketa(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if (!$form->isValid())
			$this->erroreak = true;
	}
}
