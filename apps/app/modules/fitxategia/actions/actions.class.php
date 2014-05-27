<?php

/**
 * fitxategia actions.
 *
 * @package    gerkud
 * @subpackage fitxategia
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

class fitxategiaActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->fitxategias = Doctrine::getTable('fitxategia')
			->createQuery('a')
			->execute();
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new fitxategiaForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new fitxategiaForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($fitxategia = Doctrine::getTable('fitxategia')->find(array($request->getParameter('id'))), sprintf('Object fitxategia does not exist (%s).', $request->getParameter('id')));
		$this->form = new fitxategiaForm($fitxategia);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless($fitxategia = Doctrine::getTable('fitxategia')->find(array($request->getParameter('id'))), sprintf('Object fitxategia does not exist (%s).', $request->getParameter('id')));

		$url = '/' . $fitxategia->getGertakariaId() . '/' . $fitxategia->getFitxategia();
		$fitxategia->delete();
		unlink(sfConfig::get('sf_upload_dir') . '/FILES' . $url);

		$this->redirect('fitxategia/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$fitxategia = $form->save();
			if (!$fitxategia)
			{
				$this->redirect('gertakaria/show?id=' . $form['gertakaria_id']->getValue());
				return;
			}

			//Iruzkina gehituko dugu:
			$iruzkina = new Iruzkina();
			$iruzkina->setGertakariaId($fitxategia->getGertakariaId());
			$iruzkina->setEkintzaId(4);
			$iruzkina->setLangileaId($fitxategia->getLangileaId());

			$testua = __("'%fitxategia%' fitxategia gehitu da", array('%fitxategia%' => $fitxategia->getDeskribapena()));
			$iruzkina->setTestua($testua);
			$iruzkina->save();

			$this->redirect(sprintf('gertakaria/show?id=%d#fitxategiak', $fitxategia->getGertakariaId()));
		}
	}
}
