<?php

/**
 * kalea actions.
 *
 * @package    gerkud
 * @subpackage kalea
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class kaleaActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->kaleas = Doctrine::getTable('kalea')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->kalea = Doctrine::getTable('kalea')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->kalea);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new kaleaForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new kaleaForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($kalea = Doctrine::getTable('kalea')->find(array($request->getParameter('id'))), sprintf('Object kalea does not exist (%s).', $request->getParameter('id')));
		$this->form = new kaleaForm($kalea);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($kalea = Doctrine::getTable('kalea')->find(array($request->getParameter('id'))), sprintf('Object kalea does not exist (%s).', $request->getParameter('id')));
		$this->form = new kaleaForm($kalea);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($kalea = Doctrine::getTable('kalea')->find(array($request->getParameter('id'))), sprintf('Object kalea does not exist (%s).', $request->getParameter('id')));
		$kalea->delete();

		$this->redirect('kalea/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$kalea = $form->save();

			$this->redirect('kalea/edit?id='.$kalea->getId());
		}
	}
}
