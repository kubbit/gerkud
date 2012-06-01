<?php

/**
 * iruzkina actions.
 *
 * @package    gerkud
 * @subpackage iruzkina
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class iruzkinaActions extends sfActions
{
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new iruzkinaForm();
    if (($request->getParameter('gertakaria_id')!='')&&($request->getParameter('ekintza_id')!='')&&($request->getParameter('langilea_id')!=''))
    {
           $this->form->setDefault ('gertakaria_id', $request->getParameter('gertakaria_id'));
           $this->form->setDefault ('ekintza_id', $request->getParameter('ekintza_id'));
           $this->form->setDefault ('sf_guard_user_id', $request->getParameter('sf_guard_user_id'));
    }
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new iruzkinaForm();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
/*
	$mezua = Swift_Message::newInstance();
        $mezua->setFrom('gerkud@pasaia.net');
	$erab = Doctrine::getTable('langilea')->find(array($this->gertakaria->getLangileaId()));
	$mezua->setTo($erab->getEmailAddress());
	$mezua->setSubject(($form['ekintza_id']->getValue());
	$mezua->setBody('Gorputza');
	//->attach(Swift_Attachment::fromPath('/ruta/hasta/el/archivo.zip'))
	$this->getMailer()->send($mezua);
*/

	if ($form['ekintza_id']->getValue()==5) //Egoera aldatu da....
	{
                $iruzkina = $form->save();
	}
	else if ($form['ekintza_id']->getValue()==2) //Esleipena da....
	{
		$saila= $form['saila_id']->getValue();
		$iruzkina = $form->save();
		$s=$iruzkina->getSaila($saila);

                $testua='Gertakaria "'.$s[0].'" sailari esleitu zaio. ';
		$iruzkina->setTestua($testua);
		$iruzkina->save();

		//Gertakariaren (saila/erabiltzailea) aldatzen dugu
		$gertakariak=$iruzkina->getGertakaria();
                $gertakariak[0]->setSailaId($saila);
		if ($gertakariak[0]->getEgoeraId()==1) 
		{		
			$gertakariak[0]->setEgoeraId(2);
		}
                $gertakariak[0]->save();

	}else if ($form['ekintza_id']->getValue()==3)  //Berrirekitzea
	{
		$iruzkina = $form->save();
		//Berrirekitzea da, egoera berriz ere prozesuan jarri.
		$gertakariak=$iruzkina->getGertakaria();
                $gertakariak[0]->setEgoeraId(4);
                $gertakariak[0]->save();
	
	}else //iruzkin arrunta edo fitxategia igotzea
	{
                $iruzkina = $form->save();		
	}


        $this->redirect('gertakaria/show?id='.$iruzkina->getGertakariaId());
    }
  }
}
