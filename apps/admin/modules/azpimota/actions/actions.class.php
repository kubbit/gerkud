<?php

/**
 * azpimota actions.
 *
 * @package    gerkud
 * @subpackage azpimota
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class azpimotaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->azpimotas = Doctrine::getTable('azpimota')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->azpimota = Doctrine::getTable('azpimota')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->azpimota);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new azpimotaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new azpimotaForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($azpimota = Doctrine::getTable('azpimota')->find(array($request->getParameter('id'))), sprintf('Object azpimota does not exist (%s).', $request->getParameter('id')));
    $this->form = new azpimotaForm($azpimota);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($azpimota = Doctrine::getTable('azpimota')->find(array($request->getParameter('id'))), sprintf('Object azpimota does not exist (%s).', $request->getParameter('id')));
    $this->form = new azpimotaForm($azpimota);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($azpimota = Doctrine::getTable('azpimota')->find(array($request->getParameter('id'))), sprintf('Object azpimota does not exist (%s).', $request->getParameter('id')));
    $azpimota->delete();

    $this->redirect('azpimota/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $azpimota = $form->save();

//      $this->redirect('azpimota/edit?id='.$azpimota->getId());
      $this->redirect('azpimota/index');
    }
  }
}
