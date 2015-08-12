<?php

/**
 * erabiltzaileak actions.
 *
 * @package    gerkud
 * @subpackage erabiltzaileak
 * @author     Pasaiako Udala
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class erabiltzaileakActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->erabiltzaileak = Doctrine_Core::getTable('langilea')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->erabiltzailea = Doctrine_Core::getTable('langilea')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->erabiltzailea);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new langileaForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new langileaForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($erabiltzailea = Doctrine_Core::getTable('langilea')->find(array($request->getParameter('id'))), sprintf('Object langilea does not exist (%s).', $request->getParameter('id')));
		$this->form = new langileaForm($erabiltzailea);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($erabiltzailea = Doctrine_Core::getTable('langilea')->find(array($request->getParameter('id'))), sprintf('Object langilea does not exist (%s).', $request->getParameter('id')));
		$this->form = new langileaForm($erabiltzailea);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($erabiltzailea = Doctrine_Core::getTable('langilea')->find(array($request->getParameter('id'))), sprintf('Object langilea does not exist (%s).', $request->getParameter('id')));
		$erabiltzailea->delete();

		$this->redirect('erabiltzaileak/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$erabiltzailea = $form->save();

			$this->redirect('erabiltzaileak/index');
		}
	}
}
