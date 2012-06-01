<?php

/**
 * saila actions.
 *
 * @package    gerkud
 * @subpackage saila
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sailaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->sailas = Doctrine::getTable('saila')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->saila = Doctrine::getTable('saila')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->saila);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new sailaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new sailaForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($saila = Doctrine::getTable('saila')->find(array($request->getParameter('id'))), sprintf('Object saila does not exist (%s).', $request->getParameter('id')));
    $this->form = new sailaForm($saila);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($saila = Doctrine::getTable('saila')->find(array($request->getParameter('id'))), sprintf('Object saila does not exist (%s).', $request->getParameter('id')));
    $this->form = new sailaForm($saila);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($saila = Doctrine::getTable('saila')->find(array($request->getParameter('id'))), sprintf('Object saila does not exist (%s).', $request->getParameter('id')));
    $saila->delete();

    $this->redirect('saila/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $saila = $form->save();

      $this->redirect('saila/edit?id='.$saila->getId());
    }
  }
}
