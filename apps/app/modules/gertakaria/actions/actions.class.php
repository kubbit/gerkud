<?php

/**
 * gertakaria actions.
 *
 * @package    gerkud
 * @subpackage gertakaria
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

class gertakariaActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->filter = new GertakariaFormFilter();
    if ($request->isMethod('post'))
    {
        $parametroak = $request->getParameter('gertakaria_filters');
	$this->forwardUnless($query = $parametroak, 'gertakaria', 'index');
//        $this->gertakarias = Doctrine_Core::getTable('Gertakaria') ->getForLuceneQuery($query);
        //
        $e = Doctrine_Core::getTable('Gertakaria') ->getEskaerak();
        $this->eskaerak = $e->execute();
        //


        $q = Doctrine_Core::getTable('Gertakaria') ->getForLuceneQuery($query);
        $this->gertakarias = $q->execute();
        $this->getUser()->setAttribute('parametroak', $parametroak);

    }else if ($request->getParameter('page'))
    {
        //Orrikatzetik dator
        //
        $e = Doctrine_Core::getTable('Gertakaria') ->getEskaerak();
        $this->eskaerak = $e->execute();
        //
        $parametroak = $this->getUser()->getAttribute('parametroak');
        $q = Doctrine_Core::getTable('Gertakaria') ->getForLuceneQuery($parametroak);
        $this->gertakarias = $q->execute();
        $this->getUser()->setAttribute('parametroak', $parametroak);
    }else
    {
	//
	$e = Doctrine_Core::getTable('Gertakaria') ->getEskaerak();
	$this->eskaerak = $e->execute();
	//
        $q = Doctrine_Core::getTable('Gertakaria') ->getForLuceneQuery(Array());
        $this->gertakarias = $q->execute();
        $this->getUser()->setAttribute('parametroak', Array ());
    }
    $this->pager = new sfDoctrinePager('gertakaria', sfConfig::get('app_gertakariak_orriko'));
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page',1));
    $this->pager->init();

  }

  public function executeIndexatu(sfWebRequest $request)
  {
        $this->filter = new GertakariaFormFilter();
        $q = Doctrine_Query::create()
            ->from('gertakaria g');
        $this->gertakarias = $q->execute();
//	echo "For-ean sartu baino lehen...";
	foreach ($this->gertakarias as $gertakaria)
	{
//		echo "indexatzen....<br>";
		$gertakaria->save();
	}
	$this->redirect('gertakaria/index');
  }

  public function executeShow(sfWebRequest $request)
  {
    	$this->gertakaria = Doctrine::getTable('gertakaria')->find(array($request->getParameter('id')));
/*
        $q = Doctrine_Core::getTable('Gertakaria') ->getGertakaria($request->getParameter('id'));
        $this->gertakarias = $q->execute();
        $this->gertakaria = $this->gertakarias[0];
*/

	// langilea gertakariaren saila berekoa den ala ez adierazi
	$saila = $this->gertakaria->getSaila();
	if ($this->getUser()->hasGroup($saila['name']))
		$this->sailakoa = true;
	else
		$this->sailakoa = false;


    	$this->forward404Unless($this->gertakaria);
  }

  public function executeNew(sfWebRequest $request)
  {
    	$this->form = new gertakariaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
	$this->forward404Unless($request->isMethod(sfRequest::POST));
	$this->form = new gertakariaForm();
	$this->processForm($request, $this->form);
	$this->setTemplate('new');
  }

  public function executeMapa(sfWebRequest $request)
  {
        $parametroak = $this->getUser()->getAttribute('parametroak');
        $q = Doctrine_Core::getTable('Gertakaria') ->getForLuceneQuery($parametroak);
        $this->gertakarias = $q->execute();
        $this->getUser()->setAttribute('parametroak', $parametroak);


	$this->pager = new sfDoctrinePager('gertakaria',sfConfig::get('app_gertakariak_orriko'));
	$this->pager->setQuery($q);
	$this->pager->setPage($request->getParameter('page',1));
    	$this->pager->init();


        $this->setTemplate('mapa');
  }


  public function executeEdit(sfWebRequest $request)
  {
     	$this->forward404Unless($gertakaria = Doctrine::getTable('gertakaria')->find(array($request->getParameter('id'))), sprintf('Object gertakaria does not exist (%s).', $request->getParameter('id')));
    	$this->form = new gertakariaForm($gertakaria);
  }

  public function executeKopiatu(sfWebRequest $request)
  {
        $this->forward404Unless($gertakaria = Doctrine::getTable('gertakaria')->find(array($request->getParameter('id'))), sprintf('Object gertakaria does not exist (%s).', $request->getParameter('id')));
        $this->formZahar = new gertakariaForm($gertakaria);
        $this->form = new gertakariaForm();
  }

  public function executeUpdate(sfWebRequest $request)
  {
    	$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    	$this->forward404Unless($gertakaria = Doctrine::getTable('gertakaria')->find(array($request->getParameter('id'))), sprintf('Object gertakaria does not exist (%s).', $request->getParameter('id')));
    	$this->form = new gertakariaForm($gertakaria);

    	$this->processForm($request, $this->form);

    	$this->setTemplate('edit');

	// listado de errores definidos en lib/form/doctrine/GertakariaForm.class.php para la traducción
	$erroreak = array(__('Hasiera data ezin da sortzerakoa baino lehenagokoa izan'), __('Amaiera data ezin da hasierakoa baino lehenagokoa izan'));
  }

  public function executeDelete(sfWebRequest $request)
  {
	$request->checkCSRFProtection();

    	$this->forward404Unless($gertakaria = Doctrine::getTable('gertakaria')->find(array($request->getParameter('id'))), sprintf('Object gertakaria does not exist (%s).', $request->getParameter('id')));
    	$gertakaria->delete();

    	$this->redirect('gertakaria/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {

    	$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    	if ($form->isValid())
    	{
      		$gertakaria = $form->save();
      		$this->redirect('gertakaria/show?id='.$gertakaria->getId());
    	}
  }

  public function executeEgoera(sfWebRequest $request)
  {
	$this->gertakaria = Doctrine::getTable('gertakaria')->find(array($request->getParameter('id')));
    	$this->forward404Unless($this->gertakaria);

    	$iruzkina = new Iruzkina();
    	$iruzkina->setGertakariaId($request->getParameter('id'));
	if ($request->getParameter('eg_id')==5) $iruzkina->setEkintzaId(6);
	else $iruzkina->setEkintzaId(5);
    	$iruzkina->setLangileaId($this->getUser()->getGuardUser()->getId());
	//    $testua=$iruzkina->getLangilea()."-k gertakaria ";
    	switch ($request->getParameter('eg_id'))
    	{
	    case 4:
		$testua= __("Egoera aldaketa, 'prozesuan' egoeran jarri da");
		break;
	    case 5:
               	$testua= __("Gertakaria amaitutzat ematen da");
               	break;
	    case 6:
               	$testua= __("Gertakaria ez da onartzen, baztertu da");
               	break;
    	}

    	if ($request->getParameter('eg_id')!=4)
	{
		$this->gertakaria->setIxteData($this->gertakaria->getUpdatedAt());
		$this->gertakaria->setLehentasunaId(1);
	}
        $this->gertakaria->setEgoeraId($request->getParameter('eg_id'));
        $this->gertakaria->save();

	$iruzkina->setTestua($testua);
	$iruzkina->save();

	//    $this->redirect('gertakaria/index');
    	$this->redirect('gertakaria/show?id='.$request->getParameter('id'));
  }

  public function executeInprimatu(sfWebRequest $request)
  {
        $gertakaria = Doctrine::getTable('gertakaria')->find(array($request->getParameter('id')));
	$config = sfTCPDFPluginConfigHandler::loadConfig();
        $pdf = new TCPDF();
        $pdf->SetFont("FreeSerif", "", 12);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, utf8_encode(sfConfig::get('app_erakundea')),utf8_encode(__(sfConfig::get('app_pdf_goiburua'))));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	// set color for background
	$pdf->SetFillColor(255, 255, 255);
	// set color for text
	$pdf->SetTextColor(0, 0, 0);



	$html = '<table border="0" class="gertakaria" cellspacing="0" cellpadding="4">
	    <tr><th style="background-color: #CCC;font-weight: bold;font-size:1.1em;" colspan="3">'.$gertakaria->getLaburpena().'</th></tr>
	    <tr><th style="background-color: #CCC;font-weight: bold;">' . __('Kodea') . ':</th>
		<th style="background-color: #CCC;font-weight: bold;">' . __('Mota/Azpimota') . '</th>
		<th style="background-color: #CCC;font-weight: bold;">' . __('Irekiera data') . '</th></tr>
	    <tr><td>'.$gertakaria->getId().'</td>
	       	<td>'.$gertakaria->getMota().'/'.$gertakaria->getAzpimota().'</td>
	        <td>'.date(sfConfig::get('app_data_formatoa'), strtotime($gertakaria->getCreatedAt()));

	if (($gertakaria->getEgoeraId()==5)||($gertakaria->getEgoeraId()==6))
        {
        	$html=$html.'<br>'.$gertakaria->getIxteData();
        }
	$html = $html.'</td>
	    </tr>
	    <tr>
		<th style="background-color: #CCC;font-weight: bold;">' . __('Egoera') . ':</th>
                <th style="background-color: #CCC;font-weight: bold;">' . __('Saila') . ':</th>
                <th style="background-color: #CCC;font-weight: bold;">' . __('Abisua nork') . ':</th>
                </tr><tr><td>'.$gertakaria->getEgoera().'</td><td>';

        if (($gertakaria->getEgoeraId()!=1)&&($gertakaria->getSailaId()))
        {
                $html=$html.$gertakaria->getSaila();
        }

        $html=$html.'</td><td class="azkena">
                        '.$gertakaria->getAbisuaNork().'
                      </td></tr>';
	$html=$html.'
	    <tr>
		<th style="background-color: #CCC;font-weight: bold;">' . __('Hasiera aurreikusia') . ':</th>
                <th style="background-color: #CCC;font-weight: bold;">' . __('Amaiera aurreikusia') . ':</th>
		<th style="background-color: #CCC;font-weight: bold;"></th>
            </tr>
	    <tr>
	        <td>'.$gertakaria->getHasieraAurreikusia().'</td>
		<td>'.$gertakaria->getAmaieraAurreikusia().'</td>
		<td>&nbsp;</td>
	    </tr>';
        $html=$html.'<tr><th style="background-color: #CCC;font-weight: bold;" colspan="3">' . __('Helbidea') . ':</th></tr><tr>
                        <td colspan="3" class="azkena">';
	if ($gertakaria->getKaleaId())
	{
		$html=$html.$gertakaria->getKalea().', '.$gertakaria->getKaleZbkia();
	}
	if ($gertakaria->getBarrutiaId())
	{
        	$html=$html.' ('.$gertakaria->getBarrutia().')';
	}
	if ($gertakaria->getEraikinaId())
	{
		$html .= ' -- ' . $gertakaria->getEraikina() . ' --';
	}
	$desk = str_replace("\r\n", "<br>", $gertakaria->getDeskribapena());
//	$html=$html.'</td></tr><tr><th style="background-color: #CCC;font-weight: bold;" colspan="3">Deskribapena:</th></tr>
//                <tr><td colspan="3"><p>'.$gertakaria->getDeskribapena().'</p></td></tr>
//                </table><br /><br />';

        $html=$html.'</td></tr><tr><th style="background-color: #CCC;font-weight: bold;" colspan="3">' . __('Deskribapena') . ':</th></tr>
                <tr><td colspan="3">'.$desk.'</td></tr>
                </table><br /><br />';

	$html2 = '<table>
		<tr><th style="background-color: #CCC;font-weight: bold;font-size:1.1em;" colspan="4">' . __('Iruzkinak / Oharrak') . '</th></tr>
		<tr> <th style="background-color: #CCC;font-weight: bold;" width="15%">' . __('Data') . '</th>
			<th style="background-color: #CCC;font-weight: bold;" width="13%">' . __('Nork') . '</th>
			<th style="background-color: #CCC;font-weight: bold;" width="13%">' . __('Ekintza') . '</th>
			<th style="background-color: #CCC;font-weight: bold;" width="59%">' . __('Iruzkina') . '</th></tr>';

	$k=11;
   	foreach ($gertakaria->getIruzkinak() as $i => $iruzkina)
	{
		$html2= $html2.
		'<tr><td width="15%" NOWRAP>'.substr($iruzkina->getCreated_at('U'),0,10).
		'</td><td width="13%">'.$iruzkina->getLangilea()->getFirstName().
		'</td><td width="13%">'.$iruzkina->getEkintza().
		'</td><td width="59%">'.$iruzkina->getTestua().'</td></tr>';
		$k--;
   	}
	$html2=$html2.'</table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->writeHTML($html2, true, false, true, false, '');


        $html3="<br><br>.........................................................................................................................................................................";
        $pdf->writeHTML($html3, true, false, true, false, '');
        $orriak=$pdf->getPage();


while (((int)$pdf->getY()<270)&&($orriak==$pdf->getPage()))
{
        $pdf->writeHTML($html3, true, false, true, false, '');
}
	// output
	$pdf->Output();

	// Stop symfony process
	throw new sfStopException();
  }
}
