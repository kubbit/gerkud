<?php

/**
 * ekintza actions.
 *
 * @package    gerkud
 * @subpackage ekintza
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ekintzaActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->ekintzas = Doctrine_Core::getTable('ekintza')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->ekintza = Doctrine_Core::getTable('ekintza')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->ekintza);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new ekintzaForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new ekintzaForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($ekintza = Doctrine_Core::getTable('ekintza')->find(array($request->getParameter('id'))), sprintf('Object ekintza does not exist (%s).', $request->getParameter('id')));
		$this->form = new ekintzaForm($ekintza);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($ekintza = Doctrine_Core::getTable('ekintza')->find(array($request->getParameter('id'))), sprintf('Object ekintza does not exist (%s).', $request->getParameter('id')));
		$this->form = new ekintzaForm($ekintza);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($ekintza = Doctrine_Core::getTable('ekintza')->find(array($request->getParameter('id'))), sprintf('Object ekintza does not exist (%s).', $request->getParameter('id')));
		$ekintza->delete();

		$this->redirect('ekintza/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$ekintza = $form->save();

			$this->redirect('ekintza/edit?id=' . $ekintza->getId());
		}
	}
}
