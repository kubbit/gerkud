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
	const EKINTZA_EDITATU = 'editatu';
	const EKINTZA_ESLEITU = 'esleitu';
	const EKINTZA_PROZESUAN_JARRI = 'prozesuan';
	const EKINTZA_KOPIATU = 'kopiatu';
	const EKINTZA_INPRIMATU = 'inprimatu';
	const EKINTZA_ITXI = 'itxi';
	const EKINTZA_BAZTERTU = 'baztertu';
	const EKINTZA_BERRIREKI = 'berrireki';
	const EKINTZA_GERTAKARIA = 'gertakaria';
	const EKINTZA_HISTORIKOA = 'historikoa';
	const EKINTZA_IRUZKINA = 'iruzkina';
	const EKINTZA_FITXATEGIAK = 'fitxategiak';
	const EKINTZA_BIKOIZTUAK = 'bikoiztuak';
	const EKINTZA_PLANOA = 'planoa';

	public function executeIndex(sfWebRequest $request)
	{
		if ($request->isMethod('post'))
		{
			$parametroak = $request->getParameter('gertakaria_filters');
			$this->forwardUnless($query = $parametroak, 'gertakaria', 'index');

			$q = Doctrine_Core::getTable('Gertakaria')->getBilaketaEmaitzak($query);
			$this->gertakarias = $q->execute();
			$this->getUser()->setAttribute('parametroak', $parametroak);
		}
		else if ($request->getParameter('page'))
		{
			// Orrikatzetik dator
			$parametroak = $this->getUser()->getAttribute('parametroak');
			$q = Doctrine_Core::getTable('Gertakaria')->getBilaketaEmaitzak($parametroak);
			$this->gertakarias = $q->execute();
			$this->getUser()->setAttribute('parametroak', $parametroak);
		}
		else
		{
			$q = Doctrine_Core::getTable('Gertakaria')->getBilaketaEmaitzak(Array());
			$this->gertakarias = $q->execute();
			$this->getUser()->setAttribute('parametroak', Array());
		}
		$this->pager = new sfDoctrinePager('gertakaria', sfConfig::get('gerkud_gertakariak_orriko'));
		$this->pager->setQuery($q);
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();

		$this->bilaketa = $request->getParameter('bilaketa');

		$this->zutabeakConfig = sfConfig::get('gerkud_eremuak_gertakariak');
		$this->zutabeak = array();
		$this->gertakarienZutabeakSortu();
		$this->datuak = $this->gertakarienDatuakSortu($this->pager->getResults());
	}

	public function erlazioakAurkitu($gertakariaId)
	{
		$erlazioMotaId = '1';

		$sql = 'SELECT DISTINCT hasiera_id AS gertakaria_id FROM '
			. '(SELECT hasiera_id FROM erlazioak WHERE amaiera_id = :gertakariaId and erlazio_mota_id = :erlazioMotaId'
			. ' UNION ALL SELECT amaiera_id FROM erlazioak WHERE hasiera_id = :gertakariaId and erlazio_mota_id = :erlazioMotaId)'
			. ' erlazioak order by gertakaria_id desc';
		$cn = Doctrine_Manager::getInstance()->connection();
		$cmd = $cn->prepare($sql);
		$parametroak = array
		(
			':gertakariaId' => $gertakariaId[0],
			':erlazioMotaId' =>  $erlazioMotaId
		);
		$cmd->execute($parametroak);
		$erlazionatutakoak = $cmd->fetchAll(PDO::FETCH_COLUMN, 0);
		$cmd->closeCursor();

		$this->erlazioak = $erlazionatutakoak;
	}

	public function gertakarienZutabeakSortu()
	{
		foreach ($this->zutabeakConfig as $bakoitza)
		{
			$zutabea = new stdClass();
			switch($bakoitza)
			{
				case 'id':
					$zutabea->izena = __('Id');
					$zutabea->klasea = 'id';
					break;
				case 'laburpena':
					$zutabea->izena = __('Laburpena');
					$zutabea->klasea = 'laburpena';
					break;
				case 'klasea':
					$zutabea->izena = __('Klasea');
					$zutabea->klasea = 'klasea';
					break;
				case 'arloa':
					$zutabea->izena = __('Arloa');
					$zutabea->klasea = 'arloa';
					break;
				case 'mota':
					$zutabea->izena = __('Mota');
					$zutabea->klasea = 'mota';
					break;
				case 'azpimota':
					$zutabea->izena = __('Azpimota');
					$zutabea->klasea = 'azpimota';
					break;
				case 'abisuanork':
					$zutabea->izena = __('Abisua nork');
					$zutabea->klasea = 'abisuanork';
					break;
				case 'kontaktua':
					$zutabea->izena = __('Abisua nork');
					$zutabea->klasea = 'kontaktua';
					break;
				case 'egoera':
					$zutabea->izena = __('Egoera');
					$zutabea->klasea = 'egoera';
					break;
				case 'saila':
					$zutabea->izena = __('Saila');
					$zutabea->klasea = 'saila';
					break;
				case 'langilea':
					$zutabea->izena = __('Erabiltzailea');
					$zutabea->klasea = 'langilea';
					break;
				case 'barrutia':
					$zutabea->izena = __('Barrutia');
					$zutabea->klasea = 'barrutia';
					break;
				case 'auzoa':
					$zutabea->izena = __('Auzoa');
					$zutabea->klasea = 'auzoa';
					break;
				case 'kalea':
					$zutabea->izena = __('Kalea');
					$zutabea->klasea = 'kalea';
					break;
				case 'kale_zbkia':
					$zutabea->izena = __('Zbkia');
					$zutabea->klasea = 'kale_zbkia';
					break;
				case 'deskribapena':
					$zutabea->izena = __('Deskribapena');
					$zutabea->klasea = 'deskribapena';
					break;
				case 'ixte_data':
					$zutabea->izena = __('Ixte data');
					$zutabea->klasea = 'ixte_data';
					break;
				case 'hasiera_aurreikusia':
					$zutabea->izena = __('Hasiera aurreikusia');
					$zutabea->klasea = 'hasiera_aurreikusia';
					break;
				case 'amaiera_aurreikusia':
					$zutabea->izena = __('Amaiera aurreikusia');
					$zutabea->klasea = 'amaiera_aurreikusia';
					break;
				case 'lehentasuna':
					$zutabea->izena = '';
					$zutabea->klasea = 'lehentasuna';
					break;
				case 'jatorrizkosaila':
					$zutabea->izena = __('Jatorrizko Saila');
					$zutabea->klasea = 'jatorrizkosaila';
					break;
				case 'espedientea':
					$zutabea->izena = __('Espedientea');
					$zutabea->klasea = 'espedientea';
					break;
				case 'eraikina':
					$zutabea->izena = __('Eraikina');
					$zutabea->klasea = 'eraikina';
					break;
				case 'created_at':
					$zutabea->izena = __('Irekiera');
					$zutabea->klasea = 'created_at';
					break;
				case 'updated_at':
					$zutabea->izena = __('Aldatuta');
					$zutabea->klasea = 'updated_at';
					break;
				case 'eraikinakalea':
					$zutabea->izena = __('Kalea') . ' / ' . __('Eraikina');
					$zutabea->klasea = 'eraikinakalea';
					break;
				case 'klaseamota':
					$zutabea->izena = __('Klasea') . ' / ' . __('Mota');
					$zutabea->klasea = 'klaseamota';
					break;
				case 'barrutiaeraikinakalealaburpena':
					$zutabea->izena = __('Laburpena');
					$zutabea->klasea = 'barrutiaeraikinakalealaburpena';
					break;
				case 'egoerasaila':
					$zutabea->izena = __('Egoera') . ' / ' . __('Saila');
					$zutabea->klasea = 'egoerasaila';
					break;
				case 'iruzkinak_bai':
					$zutabea->izena = __(' ');
					$zutabea->klasea = 'iruzkinak_bai';
					break;
			}
			$this->zutabeak[$bakoitza] = $zutabea;
		}
	}

	public function gertakarienDatuakSortu($cursor)
	{
		$datuak = array();

		foreach ($cursor as $fila)
		{
			$ilara = new stdClass();
			$ilara->lehentasuna = $fila->getLehentasunaId();
			$ilara->estekaId = $fila->getId();
			$ilara->egoeraId = $fila->getEgoera()->getId();
			$ilara->datuak = array();

			foreach ($this->zutabeakConfig as $bakoitza)
			{
				$balioa = '';
				switch($bakoitza)
				{
					case 'id':
						$balioa = $fila->getId();
						break;
					case 'laburpena':
						$balioa = $fila->getLaburpena();
						break;
					case 'klasea':
						$balioa = $fila->getKlasea();
						break;
					case 'arloa':
						$balioa = $fila->getArloa();
						break;
					case 'mota':
						$balioa = $fila->getMota();
						break;
					case 'azpimota':
						$balioa = $fila->getAzpimota();
						break;
					case 'abisuanork':
						$balioa = $fila->getMergedAbisuaNork();
						break;
					case 'kontaktua':
						$balioa = sprintf('%s %s', $fila->getKontaktua()->getIzena(), $fila->getKontaktua()->getAbizenak());
						break;
					case 'egoera':
						$balioa = $fila->getEgoera();
						break;
					case 'saila':
						$balioa = $fila->getSaila();
						break;
					case 'langilea':
						$balioa = $fila->getLangilea();
						break;
					case 'barrutia':
						$balioa = $fila->getBarrutia();
						break;
					case 'auzoa':
						$balioa = $fila->getAuzoa();
						break;
					case 'kalea':
						$balioa = $fila->getKalea();
						break;
					case 'kale_zbkia':
						$balioa = $fila->getKaleZbkia();
						break;
					case 'deskribapena':
						$balioa = $fila->getDeskribapena();
						break;
					case 'ixte_data':
						$balioa = ($fila->getIxteData() ? date(sfConfig::get('gerkud_data_formatoa'), strtotime($fila->getIxteData())) : $fila->getIxteData());
						break;
					case 'hasiera_aurreikusia':
						$balioa = $fila->getHasieraAurreikusia();
						break;
					case 'amaiera_aurreikusia':
						$balioa = $fila->getAmaieraAurreikusia();
						break;
					case 'lehentasuna':
						switch ($fila->getLehentasunaId())
						{
							case 1:
								$balioa = '';
								break;
							case 2:
								$balioa = '!';
								break;
							case 3:
								$balioa = '!!';
								break;
							default:
								$balioa = '';
								break;
						}
						break;
					case 'jatorrizkosaila':
						$balioa = $fila->getJatorrizkoSaila();
						break;
					case 'espedientea':
						$balioa = $fila->getEspedientea();
						break;
					case 'eraikina':
						$balioa = $fila->getEraikina();
						break;
					case 'created_at':
						$balioa = ($fila->getCreatedAt() ? date(sfConfig::get('gerkud_data_formatoa'), strtotime($fila->getCreatedAt())) : $fila->getCreatedAt());
						break;
					case 'updated_at':
						$balioa = ($fila->getUpdatedAt() ? date(sfConfig::get('gerkud_data_formatoa'), strtotime($fila->getUpdatedAt())) : $fila->getUpdatedAt());
						break;
					case 'eraikinakalea':
						if ($fila->getEraikinaId())
						{
							$balioa = $fila->getEraikina();
						}
						else if ($fila->getKaleaId())
						{
							$balioa = $fila->getKalea() . ', ' . $fila->getKaleZbkia();
						}
						else
						{
							$balioa = '';
						}
						break;
					case 'klaseamota':
						$balioa = '';
						if ($fila->getKlaseaId())
							$balioa = $fila->getKlasea();
						if ($fila->getMotaId())
							$balioa = $balioa . '###' . $fila->getMota();
						break;
					case 'barrutiaeraikinakalealaburpena':
						$balioa = '';
						if ($fila->getBarrutiaId())
							$balioa = $fila->getBarrutia();
						if ($fila->getEraikinaId())
							$balioa = $balioa . '/' . $fila->getEraikina();
						else if ($fila->getKaleaId())
							$balioa = $balioa . '/' . $fila->getKalea() . ', ' . $fila->getKaleZbkia();
						$balioa = $balioa . '###' . $fila->getLaburpena();
						break;
					case 'egoerasaila':
						$balioa = $fila->getEgoera();
						if ($fila->getSailaId())
							$balioa = $balioa . '###' . $fila->getSaila();
						break;
					case 'iruzkinak_bai':
						$balioa = $fila->getIruzkinakCount() > 0 ? '*' : ' ';
						break;
				}
				$ilara->datuak[$bakoitza] = $balioa;
			}
			array_push($datuak, $ilara);
		}
		return $datuak;
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->gertakaria = Doctrine_Core::getTable('gertakaria')->find(array($request->getParameter('id')));

		// langilea gertakariaren saila berekoa den ala ez adierazi
		$saila = $this->gertakaria->getSaila();
		if ($this->getUser()->hasCredential(array('admins', 'gerkud', 'zerbitzu'), false) && $this->getUser()->hasGroup($saila['name']))
			$this->sailakoa = true;
		else
			$this->sailakoa = false;

		$this->erlazioak = array();
		$this->erlazioakAurkitu(array($request->getParameter('id')));

		$this->forward404Unless($this->gertakaria);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new gertakariaForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		if (!$request->isMethod(sfRequest::POST))
			$this->redirect('gertakaria/new');

		$this->form = new gertakariaForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeMapa(sfWebRequest $request)
	{
		$parametroak = $this->getUser()->getAttribute('parametroak');
		$q = Doctrine_Core::getTable('Gertakaria')->getBilaketaEmaitzak($parametroak);
		$this->gertakarias = $q->execute();
		$this->getUser()->setAttribute('parametroak', $parametroak);

		$this->pager = new sfDoctrinePager('gertakaria', sfConfig::get('gerkud_gertakariak_orriko'));
		$this->pager->setQuery($q);
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();

		$this->setTemplate('mapa');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($gertakaria = Doctrine_Core::getTable('gertakaria')->find(array($request->getParameter('id'))), sprintf('Object gertakaria does not exist (%s).', $request->getParameter('id')));

		if ($gertakaria->getKontaktua()->getIzena() == null && $gertakaria->getAbisuaNork() != null)
			$gertakaria->getKontaktua()->setIzena($gertakaria->getAbisuaNork());

		$gertakaria->setAbisuaNork($gertakaria->getMergedAbisuaNork());

		$this->form = new gertakariaForm($gertakaria);
	}

	public function executeKopiatu(sfWebRequest $request)
	{
		$this->forward404Unless($gertakaria = Doctrine_Core::getTable('gertakaria')->find(array($request->getParameter('id'))), sprintf('Object gertakaria does not exist (%s).', $request->getParameter('id')));

		if ($gertakaria->getKontaktua()->getIzena() == null && $gertakaria->getAbisuaNork() != null)
			$gertakaria->getKontaktua()->setIzena($gertakaria->getAbisuaNork());

		$gertakaria->setAbisuaNork($gertakaria->getMergedAbisuaNork());

		$this->formZahar = new gertakariaForm($gertakaria);
		$this->form = new gertakariaForm();
	}

	public function executeUpdate(sfWebRequest $request)
	{
		if (!$request->isMethod(sfRequest::POST) && !$request->isMethod(sfRequest::PUT))
			$this->redirect('gertakaria/edit?id=' . $request->getParameter('id'));

		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($gertakaria = Doctrine_Core::getTable('gertakaria')->find(array($request->getParameter('id'))), sprintf('Object gertakaria does not exist (%s).', $request->getParameter('id')));
		$this->form = new gertakariaForm($gertakaria);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');

		// listado de errores definidos en lib/form/doctrine/GertakariaForm.class.php para la traducción
		$erroreak = array(__('Hasiera data ezin da irekierakoa baino lehenagokoa izan'), __('Amaiera data ezin da hasierakoa baino lehenagokoa izan'));
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($gertakaria = Doctrine_Core::getTable('gertakaria')->find(array($request->getParameter('id'))), sprintf('Object gertakaria does not exist (%s).', $request->getParameter('id')));
		$gertakaria->delete();

		$this->redirect('gertakaria/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$gertakaria = $form->save();

			if ($request->getParameter('gertakaria_itxi'))
			{
				$id = $request->getParameter('id');
				// prozesuan jarri
				$this->aldatuEgoera($id, 4);
				// itxi
				$this->aldatuEgoera($id, 5);
			}

			$this->redirect('gertakaria/show?id=' . $gertakaria->getId());
		}
	}

	public function executeEgoera(sfWebRequest $request)
	{
		$this->gertakaria = Doctrine_Core::getTable('gertakaria')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->gertakaria);

		$id = $request->getParameter('id');
		$egoera = $request->getParameter('eg_id');
		$this->aldatuEgoera($id, $egoera);

		$this->redirect('gertakaria/show?id=' . $request->getParameter('id'));
	}

	protected function aldatuEgoera($id, $egoera)
	{
		$this->gertakaria = Doctrine_Core::getTable('gertakaria')->find(array($id));
		if (!$this->gertakaria)
			return;

		// ez egoera aldaketa errepikatu
		if ($this->gertakaria->getEgoeraId() == $egoera)
			return;

		$iruzkina = new Iruzkina();
		$iruzkina->setGertakariaId($id);
		if ($egoera == 5)
			$iruzkina->setEkintzaId(6);
		else
			$iruzkina->setEkintzaId(5);
		$iruzkina->setLangileaId($this->getUser()->getGuardUser()->getId());

		switch ($egoera)
		{
			case 4:
				$testua = __("Egoera aldaketa, 'prozesuan' egoeran jarri da");
				break;
			case 5:
				$testua = __("Gertakaria amaitutzat ematen da");
				break;
			case 6:
				$testua = __("Gertakaria ez da onartzen, baztertu da");
				break;
		}

		if ($egoera == 5 OR $egoera == 6)
		{
			$this->gertakaria->setIxteData(date("Y-m-d H:i:s"));
			if (sfConfig::get('gerkud_ixterakoan_lehentasuna_berrezarri'))
				$this->gertakaria->setLehentasunaId(1);
		}
		$this->gertakaria->setEgoeraId($egoera);
		$this->gertakaria->save();

		$iruzkina->setTestua($testua);
		$iruzkina->save();
	}

	public function executeInprimatu(sfWebRequest $request)
	{
		$configEremuak = sfConfig::get('gerkud_eremuak_gaituak');

		$gertakaria = Doctrine_Core::getTable('gertakaria')->find(array($request->getParameter('id')));
		$config = sfTCPDFPluginConfigHandler::loadConfig();
		$pdf = new GerkudPDF();
		$pdf->SetFont("FreeSerif", "", 12);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, utf8_encode(sfConfig::get('gerkud_erakundea')), utf8_encode(__(sfConfig::get('gerkud_pdf_goiburua'))));
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
			<tr><th style="background-color: #CCC;font-weight: bold;font-size:1.1em;" colspan="3">' . $gertakaria->getLaburpena() . '</th></tr>';

		$html .= '<tr>';
		if (in_array('id', $configEremuak))
			$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Kodea') . ':</th>';
		if (in_array('lehentasuna', $configEremuak))
			$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Lehentasuna') . '</th>';
		if (in_array('mota', $configEremuak))
		{
			if (in_array('azpimota', $configEremuak))
			{
				$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Mota/Azpimota') . '</th>';
			}
			else
			{
				$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Mota') . '</th>';
			}
		}
		$html .= '</tr>';

		$html .= '<tr>';
		if (in_array('id', $configEremuak))
			$html .= '<td>' . $gertakaria->getId() . '</td>';
		if (in_array('lehentasuna', $configEremuak))
			$html .= '<td>' . $gertakaria->getLehentasuna() . '</td>';
		if (in_array('mota', $configEremuak))
		{
			if (in_array('azpimota', $configEremuak))
			{
				$html .= '<td>' . sprintf('%s%s', $gertakaria->getMota(), $gertakaria->getAzpimotaId() == null ? '' : '/'.$gertakaria->getAzpimota()) . '</td>';
			}
			else
			{
				$html .= '<td>' . sprintf('%s', $gertakaria->getMota()) . '</td>';
			}
		}
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Irekiera data') . '</th>';
		if (in_array('egoera', $configEremuak))
			$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Egoera') . ':</th>';
		if (in_array('saila', $configEremuak))
			$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Saila') . ':</th>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td>' . date(sfConfig::get('gerkud_data_formatoa'), strtotime($gertakaria->getCreatedAt()));
		if (in_array('ixte_data', $configEremuak))
		{
			if (($gertakaria->getEgoeraId() == 5) || ($gertakaria->getEgoeraId() == 6))
				$html .= '<br>' . date(sfConfig::get('gerkud_data_formatoa'), strtotime($gertakaria->getIxteData()));
		}
		$html .= '</td>';
		if (in_array('egoera', $configEremuak))
			$html .= '<td>' . $gertakaria->getEgoera() . '</td>';
		if (in_array('saila', $configEremuak))
		{
			if (($gertakaria->getEgoeraId() != 1) && ($gertakaria->getSailaId()))
				$html .= '<td>' . $gertakaria->getSaila() . '</td>';
		}
		$html .= '</tr>';

		$html .= '<tr>';
		if (in_array('langilea', $configEremuak))
			$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Erabiltzailea') . ':</th>';
		if (in_array('abisuanork', $configEremuak) || in_array('kontaktua_izena', $configEremuak))
			$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Abisua nork') . ':</th>';
		if (in_array('espedientea', $configEremuak))
			$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Espedientea') . ':</th>';
		$html .= '</tr>';

		$html .= '<tr>';
		if (in_array('langilea', $configEremuak))
		{
			$langilea = '';
			if (sfConfig::get('gerkud_izena_eta_abizena'))
				$langilea = $gertakaria->getLangilea();
			elseif ($gertakaria->getLangilea() != '')
				$langilea = sprintf('%s (%s %s)', $gertakaria->getLangilea(), $gertakaria->getLangilea()->getFirstName(), $gertakaria->getLangilea()->getLastName());

			$html .= '<td>' . $langilea . '</td>';
		}

		if (in_array('abisuanork', $configEremuak) || in_array('kontaktua_izena', $configEremuak))
			$html .= '<td>' . $gertakaria->getMergedAbisuaNork() . '</td>';

		if (in_array('espedientea', $configEremuak))
			$html .= '<td>' . $gertakaria->getEspedientea() . '</td>';
		$html .= '</tr>';

		if (in_array('hasiera_aurreikusia', $configEremuak) || in_array('amaiera_aurreikusia', $configEremuak))
		{
			$html .= '<tr>';
			if (in_array('hasiera_aurreikusia', $configEremuak))
				$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Hasiera aurreikusia') . ':</th>';
			if (in_array('amaiera_aurreikusia', $configEremuak))
				$html .= '<th style="background-color: #CCC;font-weight: bold;">' . __('Amaiera aurreikusia') . ':</th>';
			$html .= '<th style="background-color: #CCC;font-weight: bold;"></th><th style="background-color: #CCC;font-weight: bold;"></th>';
			$html .= '</tr>';

			$html .= '<tr>';
			if (in_array('hasiera_aurreikusia', $configEremuak))
				$html .= '<td>' . $gertakaria->getHasieraAurreikusia() . '</td>';

			if (in_array('amaiera_aurreikusia', $configEremuak))
				$html .= '<td>' . $gertakaria->getAmaieraAurreikusia() . '</td>';
			$html .= '<td>&nbsp;</td>';
			$html .= '</tr>';
		}

		if(count(array_intersect($configEremuak, array('barrutia', 'auzoa', 'kalea', 'kale_zbkia', 'eraikina'))) > 0)
		{
			$html .= '<tr>';
			$html .= '<th style="background-color: #CCC;font-weight: bold;" colspan="3">' . __('Helbidea') . ':</th>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td colspan="3" class="azkena">';

			if ($gertakaria->getKaleaId())
				$html .= $gertakaria->getKalea() . ', ' . $gertakaria->getKaleZbkia();

			if ($gertakaria->getBarrutiaId())
				$html .= ' (' . $gertakaria->getBarrutia() . ')';

			if ($gertakaria->getAuzoaId())
				$html .= ' (' . $gertakaria->getAuzoa() . ')';

			if ($gertakaria->getEraikinaId())
				$html .= ' -- ' . $gertakaria->getEraikina() . ' --';

			$html .= '</td>';
			$html .= '</tr>';
		}

		if (in_array('deskribapena', $configEremuak))
		{
			$desk = str_replace("\r\n", "<br>", $gertakaria->getDeskribapena());
			$html .= '<tr>';
			$html .= '<th style="background-color: #CCC;font-weight: bold;" colspan="3">' . __('Deskribapena') . ':</th>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td colspan="3">' . $desk . '</td>';
			$html .= '</tr>';
		}

		$html .= '</table><br /><br />';

		$html2 = '<table>
			<tr><th style="background-color: #CCC;font-weight: bold;font-size:1.1em;" colspan="4">' . __('Iruzkinak / Oharrak') . '</th></tr>
			<tr> <th style="background-color: #CCC;font-weight: bold;" width="15%">' . __('Data') . '</th>
				<th style="background-color: #CCC;font-weight: bold;" width="13%">' . __('Nork') . '</th>
				<th style="background-color: #CCC;font-weight: bold;" width="13%">' . __('Ekintza') . '</th>
				<th style="background-color: #CCC;font-weight: bold;" width="59%">' . __('Iruzkina') . '</th></tr>';

		$k = 11;
		foreach ($gertakaria->getIruzkinak() as $i => $iruzkina)
		{
			$html2 .=
			'<tr><td width="15%" NOWRAP>' . substr($iruzkina->getCreated_at('U'), 0, 10) .
			'</td><td width="13%">' . $iruzkina->getLangilea() .
			'</td><td width="13%">' . $iruzkina->getEkintza() .
			'</td><td width="59%">' . $iruzkina->getTestua() . '</td></tr>';
			$k--;
		}
		$html2 .= '</table>';
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->writeHTML($html2, true, false, true, false, '');

		$html3 = "<br><br>.........................................................................................................................................................................";
		$pdf->writeHTML($html3, true, false, true, false, '');
		$orriak = $pdf->getPage();

		while (((int)$pdf->getY() < 270) && ($orriak == $pdf->getPage()))
		{
		      $pdf->writeHTML($html3, true, false, true, false, '');
		}
		// output
		$pdf->Output();

		// Stop symfony process
		throw new sfStopException();
	}
}
