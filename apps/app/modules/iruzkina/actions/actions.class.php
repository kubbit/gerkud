<?php

/**
 * iruzkina actions.
 *
 * @package    gerkud
 * @subpackage iruzkina
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

class iruzkinaActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->iruzkinas = Doctrine::getTable('iruzkina')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->iruzkina = Doctrine::getTable('iruzkina')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->iruzkina);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new iruzkinaForm();
		if (($request->getParameter('gertakaria_id') != '') && ($request->getParameter('ekintza_id') != '') && ($request->getParameter('langilea_id') != ''))
		{
			$this->form->setDefault('gertakaria_id', $request->getParameter('gertakaria_id'));
			$this->form->setDefault('ekintza_id', $request->getParameter('ekintza_id'));
			$this->form->setDefault('sf_guard_user_id', $request->getParameter('sf_guard_user_id'));
		}
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new iruzkinaForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($iruzkina = Doctrine::getTable('iruzkina')->find(array($request->getParameter('id'))), sprintf('Object iruzkina does not exist (%s).', $request->getParameter('id')));
		$this->form = new iruzkinaForm($iruzkina);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($iruzkina = Doctrine::getTable('iruzkina')->find(array($request->getParameter('id'))), sprintf('Object iruzkina does not exist (%s).', $request->getParameter('id')));
		$this->form = new iruzkinaForm($iruzkina);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($iruzkina = Doctrine::getTable('iruzkina')->find(array($request->getParameter('id'))), sprintf('Object iruzkina does not exist (%s).', $request->getParameter('id')));
		$iruzkina->delete();

		$this->redirect('iruzkina/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			if ($form['ekintza_id']->getValue() == 2)
			{
				$saila = $form['saila_id']->getValue();
				$iruzkina = $form->save();
				$s=$iruzkina->getSaila($saila);

				//Gertakariaren (saila/erabiltzailea) aldatzen dugu
				$gertakariak=$iruzkina->getGertakaria();
				$gertakariak[0]->setSailaId($saila);
				if ($gertakariak[0]->getEgoeraId() == 1)
					$gertakariak[0]->setEgoeraId(2);
				$gertakariak[0]->save();

				$testua=__('Gertakaria "%taldea%" (a)ri esleitu zaio. ', array('%taldea%' => $s[0]));
				$iruzkina->setTestua($testua);
				$iruzkina->save();

			}
			else
			{
				$iruzkina = $form->save();
				if ($form['ekintza_id']->getValue() == 3)
				{
					//Berrirekitzea bada, prozesuan aurreko egoeran jarri.
					$gertakariak = $iruzkina->getGertakaria();
					if ($gertakariak[0]->getSailaId() != null)
						$gertakariak[0]->setEgoeraId(2);
					else
						$gertakariak[0]->setEgoeraId(1);
					$gertakariak[0]->save();
				}
			}

			$this->redirect('gertakaria/show?id=' . $iruzkina->getGertakariaId());
		}
	}
}
