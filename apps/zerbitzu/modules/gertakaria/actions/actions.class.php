<?php

/**
 * gertakaria actions.
 *
 * @package    gerkud
 * @subpackage gertakaria
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gertakariaActions extends sfActions
{

  public function executeBilaketa(sfWebRequest $request)
  {
/*
	$this->filter = new GertakariaFormFilter();
	$q = Doctrine_Query::create()
	    ->from('gertakaria g');
        $this->gertakarias = $q->execute();
*/
/*
	$this->forwardUnless($query = $request->getParameter('query'), 'gertakaria', 'index');
	$this->gertakarias = Doctrine_Core::getTable('Gertakaria') ->getForLuceneQuery($query);
*/


  }

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
    $this->pager = new sfDoctrinePager('gertakaria',40);
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page',1));
    $this->pager->init();

  }

  public function executeShow(sfWebRequest $request)
  {
    	$this->gertakaria = Doctrine::getTable('gertakaria')->find(array($request->getParameter('id')));
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


        $this->pager = new sfDoctrinePager('gertakaria',50);
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

  public function executeUpdate(sfWebRequest $request)
  {
    	$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    	$this->forward404Unless($gertakaria = Doctrine::getTable('gertakaria')->find(array($request->getParameter('id'))), sprintf('Object gertakaria does not exist (%s).', $request->getParameter('id')));
    	$this->form = new gertakariaForm($gertakaria);

    	$this->processForm($request, $this->form);

    	$this->setTemplate('edit');
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
		$testua= "Egoera aldaketa, 'prozesuan' egoeran jarri da";
		break;
	    case 5:
               	$testua= "Gertakaria amaitutzat ematen da";
               	break;
	    case 6:
               	$testua= "Gertakaria ez da onartzen, baztertu da";
               	break;
    	}
	$iruzkina->setTestua($testua);
	$iruzkina->save();

//        if ($request->getParameter('eg_id')!=4)  $this->gertakaria->setIxteData($this->gertakaria->getUpdatedAt());
        if ($request->getParameter('eg_id')!=4)
        {
                $this->gertakaria->setIxteData($this->gertakaria->getUpdatedAt());
                $this->gertakaria->setLehentasunaId(1);
        }



	$this->gertakaria->setEgoeraId($request->getParameter('eg_id'));
    	$this->gertakaria->save();

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
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, utf8_encode('PASAIAKO UDALA'),utf8_encode('Zerbitzu, Sare eta Mantentze-lanak'));
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
            <tr><th style="background-color: #CCC;font-weight: bold;">Kodea:</th>
                <th style="background-color: #CCC;font-weight: bold;">Mota/Azpimota</th>
                <th style="background-color: #CCC;font-weight: bold;">Irekiera data</th></tr>
            <tr><td>'.$gertakaria->getId().'</td>
                <td>'.$gertakaria->getMota().'/'.$gertakaria->getAzpimota().'</td>
                <td>'.$gertakaria->getCreatedAt();

        if (($gertakaria->getEgoeraId()==5)||($gertakaria->getEgoeraId()==6))
        {
                $html=$html.'<br>'.$gertakaria->getIxteData();
        }
        $html = $html.'</td>
            </tr>
            <tr>
                <th style="background-color: #CCC;font-weight: bold;">Egoera:</th>
                <th style="background-color: #CCC;font-weight: bold;">Saila:</th>
                <th style="background-color: #CCC;font-weight: bold;">Abisua / Harremanetarako:</th>
                </tr><tr><td>'.$gertakaria->getEgoera().'</td><td>';

        if (($gertakaria->getEgoeraId()!=1)&&($gertakaria->getSailaId()))
        {
                $html=$html.$gertakaria->getSaila();
        }
/*
        $html=$html.'</td><td class="azkena">
                        '.$gertakaria->getAbisuaNork().'<br>
                        '.$gertakaria->getHarremanetarako().'
                      </td></tr>
                <tr><th style="background-color: #CCC;font-weight: bold;" colspan="3">Helbidea:</th></tr><tr>
                        <td colspan="3" class="azkena">'.$gertakaria->getKalea().
                        ', '.$gertakaria->getKaleZbkia().' ('.$gertakaria->getBarrutia().')</td></tr>
                <tr><th style="background-color: #CCC;font-weight: bold;" colspan="3">Deskribapena:</th></tr>
                <tr><td colspan="3">'.$gertakaria->getDeskribapena().'</td></tr>
                </table><br /><br />';
*/

        $html=$html.'</td><td class="azkena">
                        '.$gertakaria->getAbisuaNork().'<br>
                        '.$gertakaria->getHarremanetarako().'
                      </td></tr><tr><th style="background-color: #CCC;font-weight: bold;" colspan="3">Helbidea:</th></tr><tr>
                        <td colspan="3" class="azkena">';
        if ($gertakaria->getKaleaId())
        {
                $html=$html.$gertakaria->getKalea().', '.$gertakaria->getKaleZbkia();
        }
        if ($gertakaria->getBarrutiaId())
        {
                $html=$html.' ('.$gertakaria->getBarrutia().')';
        }
        $desk = str_replace("\r\n", "<br>", $gertakaria->getDeskribapena());
//        $html=$html.'</td></tr><tr><th style="background-color: #CCC;font-weight: bold;" colspan="3">Deskribapena:</th></tr>
//                <tr><td colspan="3">'.$gertakaria->getDeskribapena().'</td></tr>
//                </table><br /><br />';
        $html=$html.'</td></tr><tr><th style="background-color: #CCC;font-weight: bold;" colspan="3">Deskribapena:</th></tr>
                <tr><td colspan="3">'.$desk.'</td></tr>
                </table><br /><br />';


        $html2 = '<table>
                <tr><th style="background-color: #CCC;font-weight: bold;font-size:1.1em;" colspan="4">Iruzkinak / Oharrak</th></tr>
                <tr> <th style="background-color: #CCC;font-weight: bold;" width="15%">Data</th>
                        <th style="background-color: #CCC;font-weight: bold;" width="13%">Nork</th>
                        <th style="background-color: #CCC;font-weight: bold;" width="10%">Ekintza</th>
                        <th style="background-color: #CCC;font-weight: bold;" width="62%">Iruzkina</th></tr>';

        $k=11;
        foreach ($gertakaria->getIruzkinak() as $i => $iruzkina)
        {
                $html2= $html2.
                '<tr><td width="15%" NOWRAP>'.substr($iruzkina->getCreated_at('U'),0,10).
                '</td><td width="13%">'.$iruzkina->getLangilea()->getFirstName().
                '</td><td width="10%">'.$iruzkina->getEkintza().
                '</td><td width="62%">'.$iruzkina->getTestua().'</td></tr>';
                $k--;
        }


        $html2=$html2.'</table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->writeHTML($html2, true, false, true, false, '');

	//$orriak=$pdf->getPage();
        // output

//echo $pdf->getY();
	$html3="<br><br>.........................................................................................................................................................................";
	$pdf->writeHTML($html3, true, false, true, false, '');
        $orriak=$pdf->getPage();


//$k=0;
while (((int)$pdf->getY()<270)&&($orriak==$pdf->getPage()))
{
//	echo $pdf->getY()."  : ".(int)$pdf->getY()."   ";
	$pdf->writeHTML($html3, true, false, true, false, '');
//	$k++;
}

        $pdf->Output();

        // Stop symfony process
        throw new sfStopException();
  }


}
