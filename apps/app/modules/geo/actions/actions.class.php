<?php

/**
 * geo actions.
 *
 * @package    gerkud
 * @subpackage geo
 * @author     Pasaiako Udala
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class geoActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->geos = Doctrine::getTable('geo')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->geo = Doctrine::getTable('geo')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->geo);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new geoForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new geoForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($geo = Doctrine::getTable('geo')->find(array($request->getParameter('id'))), sprintf('Object geo does not exist (%s).', $request->getParameter('id')));
		$this->form = new geoForm($geo);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($geo = Doctrine::getTable('geo')->find(array($request->getParameter('id'))), sprintf('Object geo does not exist (%s).', $request->getParameter('id')));
		$this->form = new geoForm($geo);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($geo = Doctrine::getTable('geo')->find(array($request->getParameter('id'))), sprintf('Object geo does not exist (%s).', $request->getParameter('id')));
		$geo->delete();

		$this->redirect('gertakaria/show?id=' . $geo->getGertakariaId());
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$geo = $form->save();

			$this->redirect('gertakaria/show?id=' . $geo->getGertakariaId());
		}
	}
}
