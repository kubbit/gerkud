<?php

/**
 * lehentasuna actions.
 *
 * @package    gerkud
 * @subpackage lehentasuna
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lehentasunaActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->lehentasunas = Doctrine_Core::getTable('lehentasuna')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->lehentasuna = Doctrine_Core::getTable('lehentasuna')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->lehentasuna);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new lehentasunaForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new lehentasunaForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($lehentasuna = Doctrine_Core::getTable('lehentasuna')->find(array($request->getParameter('id'))), sprintf('Object lehentasuna does not exist (%s).', $request->getParameter('id')));
		$this->form = new lehentasunaForm($lehentasuna);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($lehentasuna = Doctrine_Core::getTable('lehentasuna')->find(array($request->getParameter('id'))), sprintf('Object lehentasuna does not exist (%s).', $request->getParameter('id')));
		$this->form = new lehentasunaForm($lehentasuna);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($lehentasuna = Doctrine_Core::getTable('lehentasuna')->find(array($request->getParameter('id'))), sprintf('Object lehentasuna does not exist (%s).', $request->getParameter('id')));
		$lehentasuna->delete();

		$this->redirect('lehentasuna/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$lehentasuna = $form->save();

			$this->redirect('lehentasuna/index?');
		}
	}
}
