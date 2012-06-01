<?php

/**
 * mota actions.
 *
 * @package    gerkud
 * @subpackage mota
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class motaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->motas = Doctrine::getTable('mota')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->mota = Doctrine::getTable('mota')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->mota);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new motaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new motaForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($mota = Doctrine::getTable('mota')->find(array($request->getParameter('id'))), sprintf('Object mota does not exist (%s).', $request->getParameter('id')));
    $this->form = new motaForm($mota);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($mota = Doctrine::getTable('mota')->find(array($request->getParameter('id'))), sprintf('Object mota does not exist (%s).', $request->getParameter('id')));
    $this->form = new motaForm($mota);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($mota = Doctrine::getTable('mota')->find(array($request->getParameter('id'))), sprintf('Object mota does not exist (%s).', $request->getParameter('id')));
    $mota->delete();

    $this->redirect('mota/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $mota = $form->save();

      $this->redirect('mota/edit?id='.$mota->getId());
    }
  }
}
