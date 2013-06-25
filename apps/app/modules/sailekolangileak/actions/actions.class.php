<?php

/**
 * sailekolangileak actions.
 *
 * @package    gerkud
 * @subpackage sailekolangileak
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sailekolangileakActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->sailekolangileaks = Doctrine::getTable('sailekolangileak')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->sailekolangileak = Doctrine::getTable('sailekolangileak')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->sailekolangileak);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new sailekolangileakForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new sailekolangileakForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($sailekolangileak = Doctrine::getTable('sailekolangileak')->find(array($request->getParameter('id'))), sprintf('Object sailekolangileak does not exist (%s).', $request->getParameter('id')));
		$this->form = new sailekolangileakForm($sailekolangileak);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($sailekolangileak = Doctrine::getTable('sailekolangileak')->find(array($request->getParameter('id'))), sprintf('Object sailekolangileak does not exist (%s).', $request->getParameter('id')));
		$this->form = new sailekolangileakForm($sailekolangileak);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($sailekolangileak = Doctrine::getTable('sailekolangileak')->find(array($request->getParameter('id'))), sprintf('Object sailekolangileak does not exist (%s).', $request->getParameter('id')));
		$sailekolangileak->delete();

		$this->redirect('sailekolangileak/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$sailekolangileak = $form->save();

			$this->redirect('sailekolangileak/index');
		}
	}
}
