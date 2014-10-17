<?php

/**
 * erlazioak actions.
 *
 * @package    gerkud
 * @subpackage erlazioak
 * @author     Kubbit Information Technology
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
 sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

class erlazioakActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
	public function executeIndex(sfWebRequest $request)
	{
		//$this->forward('default', 'module');
		$this->erlazioak = Doctrine::getTable('erlazioak')
		     ->createQuery('a')
		     ->execute();
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		if ($form->isValid())
		{
			$iruzkina_sortu = true;

			switch ($this->parametroak['ekintza_id'])
			{
				case "0":
					$sql = 'DELETE FROM erlazioak WHERE (hasiera_id = :hasieraId AND amaiera_id = :amaieraId) OR (hasiera_id = :amaieraId AND amaiera_id = :hasieraId)';
					$cn = Doctrine_Manager::getInstance()->connection();
					$cmd = $cn->prepare($sql);
					$parametroak = array
					(
						':hasieraId' => $this->parametroak['hasiera_id'],
						':amaieraId' =>  $this->parametroak['amaiera_id']
					);
					$cmd->execute($parametroak);
					$cmd->closeCursor();
					$testua = __('Gertakari honekin dituen erlazio guztiak ezabatu dira') . ': ' . $this->parametroak['amaiera_id'];
					break;

				case "1":
					$gertakaria_erlazioaren_amaiera = Doctrine_Core::getTable('Gertakaria')->find($this->parametroak['amaiera_id']);
					if ($gertakaria_erlazioaren_amaiera->getEgoeraId()==='6')
					{
						$iruzkina_sortu = false;
						break;
					}

					$form->save();

					$gertakaria = Doctrine_Core::getTable('Gertakaria')->find($this->parametroak['hasiera_id']);

					//gertakaria baztertu gabe badago orduan baztertu
					if ($gertakaria->getEgoeraId()<>'6')
					{
						$gertakaria->setEgoeraId(6);
						$gertakaria->setIxteData(date("Y-m-d H:i:s"));
						$gertakaria->save();

						//Egoera aldaketaren iruzkina
						$iruzkina = new Iruzkina();
						$testua = __("Gertakaria ez da onartzen, baztertu da");
						$iruzkina->setTestua($testua);
						// 5 = egoera aldaketa
						$iruzkina->setEkintzaId(5);
						$iruzkina->setLangileaId($this->parametroak['langilea_id']);
						$iruzkina->setGertakariaId($this->parametroak['hasiera_id']);
						$iruzkina->save();
					}

					$testua = __('Erlazio berria sortu da.') . ' ' . __('Gertakari honen kopia da:') . ' ' . $this->parametroak['amaiera_id'];
					break;
			}
			//Erlazioaren iruzkina gehitu
			if ($iruzkina_sortu)
			{
				$iruzkina = new Iruzkina();
				$iruzkina->setTestua($testua);
				// 7 = erlazioa
				$iruzkina->setEkintzaId(7);
				$iruzkina->setLangileaId($this->parametroak['langilea_id']);
				$iruzkina->setGertakariaId($this->parametroak['hasiera_id']);
				$iruzkina->save();
			}

			$this->redirect('gertakaria/show?id=' . $this->parametroak['hasiera_id']);
		}
		else
		{
			$this->redirect('gertakaria/show?id=' . $this->parametroak['hasiera_id'] . '#erlazioak');
		}
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->parametroak = $request->getParameter('erlazioak');

		$this->form = new erlazioakForm();
		$this->processForm($request, $this->form);
	}
}
