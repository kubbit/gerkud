<?php

/**
 * langilea actions.
 *
 * @package    gerkud
 * @subpackage langilea
 * @author     Pasaiako Udala
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class langileaActions extends sfActions
{
	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($langilea = Doctrine_Core::getTable('langilea')->find(array($this->getUser()->getguardUser()->getId())), sprintf('Object langilea does not exist (%s).', $request->getParameter('id')));

		$this->form = new langileaForm($langilea);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($langilea = Doctrine_Core::getTable('langilea')->find(array($request->getParameter('id'))), sprintf('Object langilea does not exist (%s).', $request->getParameter('id')));
		$this->form = new langileaForm($langilea);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$langilea = $form->save();

			$this->redirect('langilea/edit?id='.$langilea->getId());
		}
	}
}
