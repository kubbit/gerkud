<?php

/**
 * Gertakari Zerrendatuak
 *
 * @package    gerkud
 * @subpackage zerrendatu
 * @author     Kubbit Information Technology
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));

class zerrendatuActions extends sfActions
{
	const ZUTABE_ARTEKO_DISTANTZIA = 5;

	const IDX_FIELD = 0;
	const IDX_HEADER = 1;
	const IDX_WIDTH = 2;

	protected $LIST_FIELDS;

	protected $configEremuak;
	protected $orden;
	protected $iragazkiak;

	protected function configure()
	{
		$this->configEremuak = sfConfig::get('gerkud_eremuak_gaituak');
		$this->loadSailkapena();

		$this->LIST_FIELDS = array
		(
//			array(FIELD,		HEADER,					COL. WIDTH)
			array('lehentasuna', 	'',					10),
			array('kodea',		__('Kodea'),				30),
			array('egoera',		__('Egoera'),				54),
			array('laburpena',	__('Laburpena'),			218),
			array('barrutia',	__('Barrutia'),				54),
			array('auzoa',		__('Auzoa'),				54),
			array('kalea',		__('Kalea') . ' / ' . __('Eraikina'),	150),
			array('abisuanork',	__('Eskatzailea'),			80),
			array('erabiltzailea',	__('Erabiltzailea'),			54),
			array('irekiera_data',	__('Irekiera data'),			54),
			array('ixte_data',	__('Ixte data'),			54)
		);

		// ezabatu aktibo ez dauden eremuak
		if (!in_array('barrutia', $this->configEremuak))
			unset($this->LIST_FIELDS[array_search('barrutia', array_column($this->LIST_FIELDS, self::IDX_FIELD))]);
		elseif (!in_array('auzoa', $this->configEremuak))
			unset($this->LIST_FIELDS[array_search('auzoa', array_column($this->LIST_FIELDS, self::IDX_FIELD))]);
	}

	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->zerrendatuaForm = new ZerrendatuaForm();

		if (!$request->isMethod(sfRequest::POST))
			return;

		$this->processForm($request, $this->zerrendatuaForm);
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if (!$form->isValid())
			return;

		$this->formularioa = $request->getParameter('zerrendatu');
		$this->configure();

		switch ($request->getPostParameter('submit'))
		{
			case 'CSV':
				$this->exportCSV();
			default:
				$this->exportPDF();
		}
	}

	protected function formGetValue($key)
	{
		if (!$this->formularioa)
			return null;

		if (!array_key_exists($key, $this->formularioa))
			return null;

		return $this->formularioa[$key];
	}

	protected function getSQLWhere(&$parametroak)
	{
		$condiciones = array();
		$this->iragazkiak = new StdClass();

		$this->iragazkiak->irekiera_noiztik = $this->formGetValue('irekiera_noiztik');
		if ($this->iragazkiak->irekiera_noiztik)
		{
			array_push($condiciones, 'date(g.created_at) >= date(:irekiera_noiztik)');
			$parametroak[':irekiera_noiztik'] = $this->iragazkiak->irekiera_noiztik;
		}
		$this->iragazkiak->irekiera_nora = $this->formGetValue('irekiera_nora');
		if ($this->iragazkiak->irekiera_nora)
		{
			array_push($condiciones, 'date(g.created_at) <= date(:irekiera_nora)');
			$parametroak[':irekiera_nora'] = $this->iragazkiak->irekiera_nora;
		}
		$this->iragazkiak->ixte_noiztik = $this->formGetValue('ixte_noiztik');
		if ($this->iragazkiak->ixte_noiztik)
		{
			array_push($condiciones, 'date(g.ixte_data) >= date(:ixte_noiztik)');
			$parametroak[':ixte_noiztik'] = $this->iragazkiak->ixte_noiztik;
		}
		$this->iragazkiak->ixte_nora = $this->formGetValue('ixte_nora');
		if ($this->iragazkiak->ixte_nora)
		{
			array_push($condiciones, 'date(g.ixte_data) <= date(:ixte_nora)');
			$parametroak[':ixte_nora'] = $this->iragazkiak->ixte_nora;
		}
		$this->iragazkiak->klasea = '';
		if ($this->formGetValue('klasea'))
		{
			array_push($condiciones, 'g.klasea_id = :klasea');
			$parametroak[':klasea'] = $this->formularioa['klasea'];

			$this->iragazkiak->klasea = Doctrine_Core::getTable('Klasea')->find(array($this->formularioa['klasea']))->getIzena();
		}
		$this->iragazkiak->arloa = '';
		if ($this->formGetValue('arloa'))
		{
			array_push($condiciones, 'g.arloa_id = :arloa');
			$parametroak[':arloa'] = $this->formularioa['arloa'];

			$this->iragazkiak->arloa = Doctrine_Core::getTable('Arloa')->find(array($this->formularioa['arloa']))->getIzena();
		}
		$this->iragazkiak->saila = '';
		if ($this->formGetValue('saila'))
		{
			array_push($condiciones, 'g.saila_id = :saila');
			$parametroak[':saila'] = $this->formularioa['saila'];

			$this->iragazkiak->saila = Doctrine_Core::getTable('Saila')->find(array($this->formularioa['saila']))->getName();
		}
		$this->iragazkiak->mota = '';
		if ($this->formGetValue('mota_id'))
		{
			array_push($condiciones, 'g.mota_id = :mota');
			$parametroak[':mota'] = $this->formularioa['mota_id'];

			$this->iragazkiak->mota = Doctrine_Core::getTable('Mota')->find(array($this->formularioa['mota_id']))->getIzena();
		}
		$this->iragazkiak->azpiMota = '';
		if ($this->formGetValue('azpimota_id'))
		{
			array_push($condiciones, 'g.azpimota_id = :azpimota');
			$parametroak[':azpimota'] = $this->formularioa['azpimota_id'];

			$this->iragazkiak->azpiMota = Doctrine_Core::getTable('Azpimota')->find(array($this->formularioa['azpimota_id']))->getIzena();
		}
		$this->iragazkiak->barrutia = '';
		if (in_array('barrutia', $this->configEremuak) && $this->formGetValue('barrutia'))
		{
			array_push($condiciones, 'g.barrutia_id = :barrutia');
			$parametroak[':barrutia'] = $this->formularioa['barrutia'];

			$this->iragazkiak->barrutia = Doctrine_Core::getTable('Barrutia')->find(array($this->formularioa['barrutia']))->getIzena();
		}
		$this->iragazkiak->auzoa = '';
		if (in_array('auzoa', $this->configEremuak) && $this->formGetValue('auzoa'))
		{
			array_push($condiciones, 'g.auzoa_id = :auzoa');
			$parametroak[':auzoa'] = $this->formularioa['auzoa'];

			$this->iragazkiak->auzoa = Doctrine_Core::getTable('Auzoa')->find(array($this->formularioa['auzoa']))->getIzena();
		}
		$this->iragazkiak->kalea = '';
		if ($this->formGetValue('kalea'))
		{
			array_push($condiciones, 'g.kalea_id = :kalea');
			$parametroak[':kalea'] = $this->formularioa['kalea'];

			$this->iragazkiak->kalea = Doctrine_Core::getTable('Kalea')->find(array($this->formularioa['kalea']))->getIzena();
		}
		$this->iragazkiak->eraikina = '';
		if ($this->formGetValue('eraikina'))
		{
			array_push($condiciones, 'g.eraikina_id = :eraikina');
			$parametroak[':eraikina'] = $this->formularioa['eraikina'];

			$this->iragazkiak->eraikina = Doctrine_Core::getTable('Eraikina')->find(array($this->formularioa['eraikina']))->getIzena();
		}
		$this->iragazkiak->egoera = '';
		if ($this->formGetValue('egoera'))
		{
			array_push($condiciones, 'g.egoera_id = :egoera');
			$parametroak[':egoera'] = $this->formularioa['egoera'];

			$this->iragazkiak->egoera = Doctrine_Core::getTable('Egoera')->find(array($this->formularioa['egoera']))->getIzena();
		}

		if (sfConfig::get('gerkud_api_saila_bakarrik'))
		{
			$taldeak = sfContext::getInstance()->getUser()->getguardUser()->getGroups();
			$taldeakId = Array();
			foreach ($taldeak as $taldea)
				array_push($taldeakId, $taldea->getId());

			if (empty($taldeakId))
				array_push($condiciones, '(g.herritarrena IS NULL OR g.saila_id IS NULL)');
			else
				array_push($condiciones, sprintf('(g.herritarrena IS NULL OR g.saila_id IS NOT NULL OR (g.herritarrena IS NOT NULL AND g.saila_id IN (%s)))', implode(',', $taldeakId)));
		}

		if (count($condiciones) > 0)
			return ' WHERE ' . implode(' AND ', $condiciones);

		return '';
	}

	protected function loadSailkapena()
	{
		$SAILKAPEN_KANPOAK = array
		(
			// codigos definidos en el formulario ZerrendatuaForm.class.php
			0 => '',
			1 => 'saila',
			2 => 'barrutia',
			3 => 'auzoa',
			4 => 'mota'
		);

		$this->orden = array();

		// eliminar campos que no estan activos en la configuracion
		if (!in_array('barrutia', $this->configEremuak))
			array_splice($SAILKAPEN_KANPOAK, array_search('barrutia', $SAILKAPEN_KANPOAK), 1);
		else if (!in_array('auzoa', $this->configEremuak))
			array_splice($SAILKAPEN_KANPOAK, array_search('auzoa', $SAILKAPEN_KANPOAK), 1);

		if ($this->formularioa['sailkapena1'] > 0)
			array_push($this->orden, $SAILKAPEN_KANPOAK[$this->formularioa['sailkapena1']]);
		if ($this->formularioa['sailkapena2'] > 0)
			array_push($this->orden, $SAILKAPEN_KANPOAK[$this->formularioa['sailkapena2']]);
		if ($this->formularioa['sailkapena3'] > 0)
			array_push($this->orden, $SAILKAPEN_KANPOAK[$this->formularioa['sailkapena3']]);
	}

	protected function getSQLOrder()
	{
		if (count($this->orden) == 0)
			return '';

		$sql = '';

		// crear ORDER BY con campos de clasificación nulos al final
		for ($i = 0; $i < count($this->orden); $i++)
		{
			if ($i == 0)
				$sql .= ' ORDER BY ';
			else
				$sql .= ', ';

			$sql .= sprintf('isnull(%s), %s', $this->orden[$i], $this->orden[$i]);
		}

		return $sql;
	}

	protected function getGertakariak()
	{
		if (sfConfig::get('gerkud_izena_eta_abizena'))
			$erabiltzailea = ' concat_ws(" ", u.first_name, u.last_name)';
		else
			$erabiltzailea = ' u.username';

		$sql = 'SELECT '
		 . '  CASE g.lehentasuna_id'
		 . '   WHEN 2 THEN "!"'
		 . '   WHEN 3 THEN "!!"'
		 . '   ELSE NULL'
		 . '  END AS lehentasuna,'
		 . '  s.name AS saila, m.izena AS mota, g.id AS kodea, e.izena AS egoera, laburpena,'
		 . '  b.izena AS barrutia, a.izena AS auzoa, coalesce(er.izena, concat_ws(", ", k.izena, g.kale_zbkia)) AS kalea,'
		 . '  ' . $erabiltzailea . ' AS erabiltzailea, abisuanork, coalesce(date(g.created_at), "-") AS irekiera_data, coalesce(date(ixte_data), "-") AS ixte_data,'
		 . '  coalesce(concat_ws("; ", nullif(concat_ws(" ", ko.izena, ko.abizenak), " "), nullif(ko.telefonoa, ""), nullif(ko.posta, ""), nullif(ko.nan, "")), abisuanork) AS abisuanork'
		 . ' FROM gertakaria g'
		 . '  LEFT JOIN sf_guard_user u ON u.id = g.langilea_id'
		 . '  LEFT JOIN sf_guard_group_translation s ON s.id = g.saila_id AND s.lang = :hizkuntza'
		 . '  LEFT JOIN mota_translation m ON m.id = g.mota_id AND m.lang = :hizkuntza'
		 . '  LEFT JOIN egoera_translation e ON e.id = g.egoera_id AND e.lang = :hizkuntza'
		 . '  LEFT JOIN barrutia b ON b.id = g.barrutia_id'
		 . '  LEFT JOIN auzoa a ON a.id = g.auzoa_id'
		 . '  LEFT JOIN kalea k ON k.id = g.kalea_id'
		 . '  LEFT JOIN eraikina er ON er.id = g.eraikina_id'
		 . '  LEFT JOIN kontaktua ko ON ko.id = g.kontaktua_id';

		$parametroak = array
		(
			':hizkuntza' => $this->getUser()->getCulture()
		);

		$sql .= $this->getSQLWhere($parametroak);
		$sql .= $this->getSQLOrder();

		$cn = Doctrine_Manager::getInstance()->connection();
		$cmd = $cn->prepare($sql);
		$cmd->execute($parametroak);

		// obtener datos sin indices numericos
		$gertaerak = $cmd->fetchAll(PDO::FETCH_ASSOC);
		$cmd->closeCursor();

		return $gertaerak;
	}

	public function exportCSV()
	{
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename=gerkud.csv');

		$csv = fopen('php://output', 'w');
		try
		{
			$headers = array_column($this->LIST_FIELDS, self::IDX_HEADER);
			fputcsv($csv, $headers);

			foreach ($this->getGertakariak() as $datuak)
			{
				$csvData = array();
				foreach ($this->LIST_FIELDS as $field)
					$csvData[] = $datuak[$field[self::IDX_FIELD]];

				fputcsv($csv, $csvData);
			}
		}
		finally
		{
			fclose($csv);
		}

		// Stop symfony process
		throw new sfStopException();
	}

	public function exportPDF()
	{
		$config = sfTCPDFPluginConfigHandler::loadConfig();
		// 'L' = Landscape orientation
		$pdf = new GerkudPDF('L');
		$pdf->SetFont('FreeSerif', '', 10);
		$pdf->SetMargins(PDF_MARGIN_LEFT / 2, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT / 2);
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, utf8_encode(sfConfig::get('gerkud_erakundea')), utf8_encode(__(sfConfig::get('gerkud_pdf_goiburua'))));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->AddPage();

		// set color for background
		$pdf->SetFillColor(255, 255, 255);
		// set color for text
		$pdf->SetTextColor(0, 0, 0);

		$pdf->writeHTML('<html><head></head><body>', false, false, true, false, '');

		$gertaerak = $this->getGertakariak();

		$htmlIragazkiak = '<table>';
		$htmlIragazkiak .= sprintf('<tr><td width="50"></td><td width="85">%s:</td><td width="150" style="border-bottom: 0.25px solid black;">%s</td><td width="180"></td>', __('Klasea'), $this->iragazkiak->klasea);
		$htmlIragazkiak .= sprintf('<td width="85">%s:</td><td width="150" style="border-bottom: 0.25px solid black;">%s</td></tr>', __('Kalea'), $this->iragazkiak->kalea);
		$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Saila'), $this->iragazkiak->saila);
		$htmlIragazkiak .= sprintf('<td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td></tr>', __('Eraikina'), $this->iragazkiak->eraikina);

		if (in_array('barrutia',$this->configEremuak) && in_array('auzoa',$this->configEremuak))
		{
			$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Barrutia'), $this->iragazkiak->barrutia);
			$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Auzoa'), $this->iragazkiak->auzoa);
		}
		elseif (in_array('barrutia',$this->configEremuak))
			$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Barrutia'), $this->iragazkiak->barrutia);
		else
			$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Auzoa'), $this->iragazkiak->auzoa);

		$htmlIragazkiak .= sprintf('<td>%s:</td><td style="border-bottom: 0.25px solid black;">%s%s%s</td></tr>', __('Irekiera data'), $this->iragazkiak->irekiera_noiztik, !empty($this->iragazkiak->irekiera_noiztik) && !empty($this->iragazkiak->irekiera_nora) ? ' - ' : '', $this->iragazkiak->irekiera_nora);
		$htmlIragazkiak .= sprintf('<tr><td></td><td></td><td></td><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s%s%s</td></tr>', __('Ixte data'), $this->iragazkiak->ixte_noiztik, !empty($this->iragazkiak->ixte_noiztik) && !empty($this->iragazkiak->ixte_nora) ? ' - ' : '', $this->iragazkiak->ixte_nora);
		$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s%s</td><td></td>', __('Mota'), $this->iragazkiak->mota, empty($this->iragazkiak->azpiMota) ? '' : ' / ' . $this->iragazkiak->azpiMota);
		$htmlIragazkiak .= sprintf('<td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td></tr>', __('Egoera'), $this->iragazkiak->egoera);
		if (in_array('arloa',$this->configEremuak))
			$htmlIragazkiak .= sprintf('<tr><td width="50"></td><td width="85">%s:</td><td width="150" style="border-bottom: 0.25px solid black;">%s</td><td width="180"></td></tr>', __('Arloa'), $this->iragazkiak->arloa);
		$htmlIragazkiak .= '</table>';

		$htmlSailkapen = '<table style="text-align: right; width: 90%"><tr>' . sprintf('<td>%s:</td>', __('Sailkapena'));
		if ($this->formularioa['sailkapena1'] > 0)
		{
			$htmlSailkapen .= sprintf('<td style="font-weight: bold">%s</td>', strtoupper(__(ZerrendatuaForm::$sailkapena[$this->formularioa['sailkapena1']])));
		}
		if ($this->formularioa['sailkapena2'] > 0)
		{
			$htmlSailkapen .= sprintf('<td style="font-weight: bold">%s</td>', strtoupper(__(ZerrendatuaForm::$sailkapena[$this->formularioa['sailkapena2']])));
		}
		if ($this->formularioa['sailkapena3'] > 0)
		{
			$htmlSailkapen .= sprintf('<td style="font-weight: bold">%s</td>', strtoupper(__(ZerrendatuaForm::$sailkapena[$this->formularioa['sailkapena3']])));
		}
		$htmlSailkapen .= '</tr></table>';

		$html = '<div style="background-color: #e8e8e8;">';

		if (count($this->orden) > 0)
			$html .= '<br />' . $htmlSailkapen . '<br />';

		$html .= $htmlIragazkiak;
		$html .= '</div>';

		if (sfConfig::get('gerkud_zerrendak_iragazkiak_erakutsi'))
			$pdf->writeHTML($html, false, false, true, false, '');


		$sailkapen1 = '-';
		$sailkapen2 = '-';
		$sailkapen3 = '-';
		$goiburua1 = '';
		$goiburua2 = '';
		$goiburua3 = '';
		$lehenTaula = true;
		foreach ($gertaerak as $datuak)
		{
			$aldaketak = false;
			$orriBerria = false;
			$goiburuak = '';
			if (count($this->orden) >= 1 && $datuak[$this->orden[0]] != $sailkapen1)
			{
				$sailkapen1 = $datuak[$this->orden[0]];
				$goiburua1 = sprintf('<tr><td style="background-color: #aaaaaa; font-size: 34px; font-weight: bold; text-indent: 1em; vertical-align: middle; border: 1px solid black;">%s</td></tr>', $sailkapen1);
				$goiburuak .= $goiburua1;
				$aldaketak = true;
				$orriBerria = true;
			}

			if (count($this->orden) >= 2 && $datuak[$this->orden[1]] != $sailkapen2)
			{
				$sailkapen2 = $datuak[$this->orden[1]];
				$goiburua2 = sprintf('<tr><td style="background-color: #cccccc; font-size: 22px; font-weight: bold; text-indent: 10em">%s</td></tr>', $sailkapen2);
				$goiburuak .= $goiburua2;
				$aldaketak = true;
			}

			if (count($this->orden) >= 3 && $datuak[$this->orden[2]] != $sailkapen3)
			{
				$sailkapen3 = $datuak[$this->orden[2]];
				$goiburua3 = sprintf('<tr><td style="background-color: #e8e8e8; font-style: italic; text-indent: 20em">%s</td></tr>', $sailkapen3);
				$goiburuak .= $goiburua3;
				$aldaketak = true;
			}

			if ($aldaketak || $lehenTaula)
			{
				if (!$lehenTaula)
				{
					/*
					// Cuando coincide que el último registro de una sección completa una página, el cierre de la etiqueta </table>
					// fuera de la transacción provoca el salto de página añadiendo una página en blanco.
					$pdf->writeHTML('</table>', false, false, true, false, '');
					*/

					if ($orriBerria)
						$pdf->AddPage();
				}

				if ($aldaketak)
					$pdf->writeHTML('<table>' . $goiburuak . '</table>', false, false, true, false, '');

				$lehenTaula = false;

				// No se puede usar cellspacing porque se escribe la tabla de manera parcial
				// y una vez usada la funcion writeHTML() restaura su valor por defecto.
				// Como solucion, se añaden columnas separadoras vacias
				$izenak = '<table>';
				$izenak .= '<thead><tr style="text-decoration: underline">';
				foreach ($this->LIST_FIELDS as $field)
				{
					$izenak .= sprintf('<th width="%d">%s</th>', $field[self::IDX_WIDTH], htmlentities($field[self::IDX_HEADER]));
					$izenak .= sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA);
				}
				$izenak .= '</tr></thead>';
				$pdf->writeHTML($izenak, false, false, true, false, '');
			}

			$pdf->startTransaction();

			// nobr evita que unicamente parte de la fila pase a una nueva pagina
			$html = '<tr nobr="true">';
			foreach ($this->LIST_FIELDS as $field)
			{
				$html .= sprintf('<td width="%d">%s</td>', $field[self::IDX_WIDTH], htmlentities($datuak[$field[self::IDX_FIELD]]));
				$html .= sprintf('<td width="%d"></td>', self::ZUTABE_ARTEKO_DISTANTZIA);
			}
			$html .= '</tr>';

			$orria = $pdf->getPage();
			$pdf->writeHTML($html, false, false, true, false, '');

			// si pasa a una nueva pagina, deshacer la ultima escritura,
			// añadir todas las cabeceras y volver a escribir la ultima fila
			if ($orria <> $pdf->getPage())
			{
				$pdf->rollbackTransaction(true);
				//$pdf->AddPage();
				$pdf->startTransaction();
				$pdf->writeHTML('<table>' . $goiburua1 . $goiburua2 . $goiburua3 . '</table>', false, false, true, false, '');
				$pdf->writeHTML($izenak, false, false, true, false, '');
				$pdf->writeHTML($html, false, false, true, false, '');
			}
			$pdf->commitTransaction();
		}
		/*
		// Cuando coincide que el último registro de una sección completa una página, el cierre de la etiqueta </table>
		// fuera de la transacción provoca el salto de página añadiendo una página en blanco.
		if ($gertaerak)
			$pdf->writeHTML('</table>', false, false, true, false, '');
		*/

		$pdf->Output();

		// Stop symfony process
		throw new sfStopException();
	}
}
