<?php

/**
 * planifikazioa actions.
 *
 * @package    gerkud
 * @subpackage planifikazioa
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class planifikazioaActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->planifikazioas = Doctrine_Core::getTable('planifikazioa')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->planifikazioa = Doctrine_Core::getTable('planifikazioa')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->planifikazioa);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new planifikazioaForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new planifikazioaForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($planifikazioa = Doctrine_Core::getTable('planifikazioa')->find(array($request->getParameter('id'))), sprintf('Object planifikazioa does not exist (%s).', $request->getParameter('id')));
		$this->form = new planifikazioaForm($planifikazioa);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($planifikazioa = Doctrine_Core::getTable('planifikazioa')->find(array($request->getParameter('id'))), sprintf('Object planifikazioa does not exist (%s).', $request->getParameter('id')));
		$this->form = new planifikazioaForm($planifikazioa);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($planifikazioa = Doctrine_Core::getTable('planifikazioa')->find(array($request->getParameter('id'))), sprintf('Object planifikazioa does not exist (%s).', $request->getParameter('id')));
		$planifikazioa->delete();

		$this->redirect('planifikazioa/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$planifikazioa = $form->save();

			$this->redirect('planifikazioa/edit?id=' . $planifikazioa->getId());
		}
	}
}
