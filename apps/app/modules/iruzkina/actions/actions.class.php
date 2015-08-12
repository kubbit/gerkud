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
		$this->iruzkinas = Doctrine_Core::getTable('iruzkina')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->iruzkina = Doctrine_Core::getTable('iruzkina')->find(array($request->getParameter('id')));
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
		$this->forward404Unless($iruzkina = Doctrine_Core::getTable('iruzkina')->find(array($request->getParameter('id'))), sprintf('Object iruzkina does not exist (%s).', $request->getParameter('id')));
		$this->form = new iruzkinaForm($iruzkina);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($iruzkina = Doctrine_Core::getTable('iruzkina')->find(array($request->getParameter('id'))), sprintf('Object iruzkina does not exist (%s).', $request->getParameter('id')));
		$this->form = new iruzkinaForm($iruzkina);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($iruzkina = Doctrine_Core::getTable('iruzkina')->find(array($request->getParameter('id'))), sprintf('Object iruzkina does not exist (%s).', $request->getParameter('id')));
		$iruzkina->delete();

		$this->redirect('iruzkina/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		$url = sprintf('gertakaria/show?id=%d', $form['gertakaria_id']->getValue());
		if ($form->isValid())
		{
			$iruzkina = $form->save();
			$gertakariak = $iruzkina->getGertakaria();
			if ($gertakariak->count() == 0)
				throw new Exception(sprintf('Gertakari gabeko iruzkina: %s', $iruzkina->getId()));
			$gertakaria = $gertakariak[0];

			if ($form['ekintza_id']->getValue() == 2)
			{
				$saila = $form['saila_id']->getValue();
				$s=$iruzkina->getSaila($saila);

				//Gertakariaren (saila/erabiltzailea) aldatzen dugu
				$gertakaria->setSailaId($saila);
				if ($gertakaria->getEgoeraId() == 1)
					$gertakaria->setEgoeraId(2);
				// aldaketa iruzkina gorde aurretik gorde behar da, bestela gertakariko aldaketak berrezartzen dira
				$gertakaria->save();

				$testua=__('Gertakaria "%taldea%" (a)ri esleitu zaio. ', array('%taldea%' => $s[0]));
				$iruzkina->setTestua($testua);
				$iruzkina->save();
			}
			else
			{
				if ($form['ekintza_id']->getValue() == 3)
				{
					//Berrirekitzea bada, prozesuan aurreko egoeran jarri.
					if ($gertakaria->getSailaId() != null)
						$gertakaria->setEgoeraId(2);
					else
						$gertakaria->setEgoeraId(1);
					// aldaketa iruzkina gorde aurretik gorde behar da, bestela gertakariko aldaketak berrezartzen dira
					$gertakaria->save();

					//Bikoizpen erlazioak ezabatzen dira
					$sql = 'DELETE FROM erlazioak WHERE hasiera_id = :hasieraId';
					$cn = Doctrine_Manager::getInstance()->connection();
					$cmd = $cn->prepare($sql);
					$parametroak = array
					(
						':hasieraId' => $gertakaria->getId()
					);
					$cmd->execute($parametroak);
					$cmd->closeCursor();
				}
			}

			switch ($form['ekintza_id']->getValue())
			{
				// Iruzkina
				case 1:
					$url .= '#historikoa';
					break;
				// Fitxategia
				case 4:
					$url .= '#fitxategiak';
					break;
			}

			// eguneratze data berritu
			$gertakaria->setUpdatedAt(null); // gertakaria gordetzea behartu
			$gertakaria->save();
		}
		elseif ($form['ekintza_id']->getValue() == 1)
		{
			$url .= '#iruzkina';
		}

		$this->redirect($url);
	}
}
