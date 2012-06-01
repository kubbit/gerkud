<?php

/**
 * barrutia actions.
 *
 * @package    gerkud
 * @subpackage barrutia
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class barrutiaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->barrutias = Doctrine::getTable('barrutia')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->barrutia = Doctrine::getTable('barrutia')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->barrutia);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new barrutiaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new barrutiaForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($barrutia = Doctrine::getTable('barrutia')->find(array($request->getParameter('id'))), sprintf('Object barrutia does not exist (%s).', $request->getParameter('id')));
    $this->form = new barrutiaForm($barrutia);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($barrutia = Doctrine::getTable('barrutia')->find(array($request->getParameter('id'))), sprintf('Object barrutia does not exist (%s).', $request->getParameter('id')));
    $this->form = new barrutiaForm($barrutia);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($barrutia = Doctrine::getTable('barrutia')->find(array($request->getParameter('id'))), sprintf('Object barrutia does not exist (%s).', $request->getParameter('id')));
    $barrutia->delete();

    $this->redirect('barrutia/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $barrutia = $form->save();

//      $this->redirect('barrutia/edit?id='.$barrutia->getId());
      $this->redirect('barrutia/index');
    }
  }
}
