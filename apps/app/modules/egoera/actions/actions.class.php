<?php

/**
 * egoera actions.
 *
 * @package    gerkud
 * @subpackage egoera
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class egoeraActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->egoeras = Doctrine::getTable('egoera')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->egoera = Doctrine::getTable('egoera')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->egoera);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new egoeraForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new egoeraForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($egoera = Doctrine::getTable('egoera')->find(array($request->getParameter('id'))), sprintf('Object egoera does not exist (%s).', $request->getParameter('id')));
		$this->form = new egoeraForm($egoera);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($egoera = Doctrine::getTable('egoera')->find(array($request->getParameter('id'))), sprintf('Object egoera does not exist (%s).', $request->getParameter('id')));
		$this->form = new egoeraForm($egoera);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($egoera = Doctrine::getTable('egoera')->find(array($request->getParameter('id'))), sprintf('Object egoera does not exist (%s).', $request->getParameter('id')));
		$egoera->delete();

		$this->redirect('egoera/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$egoera = $form->save();

			$this->redirect('egoera/index');
		}
	}
}
