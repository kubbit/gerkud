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
		if ($this->formularioa)
			$this->inprimatu();
	}
	public function inprimatu()
	{
		$configEremuak = sfConfig::get('app_gerkud_eremuak');

		$config = sfYaml::load(sfConfig::get("sf_app_config_dir") . '/pdf_configs.yml');
		// 'L' = Landscape orientation
		$pdf = new GerkudPDF('L');
		$pdf->SetFont('FreeSerif', '', 10);
		$pdf->SetMargins(PDF_MARGIN_LEFT / 2, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT / 2);
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetHeaderData($config['default']['PDF_HEADER_LOGO'], $config['default']['PDF_HEADER_LOGO_WIDTH'], utf8_encode(sfConfig::get('app_erakundea')), utf8_encode(__(sfConfig::get('app_pdf_goiburua'))));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->AliasNbPages();
		$pdf->AddPage();

		// set color for background
		$pdf->SetFillColor(255, 255, 255);
		// set color for text
		$pdf->SetTextColor(0, 0, 0);

		$pdf->writeHTML('<html><head></head><body>', false, false, true, false, '');

		if (sfConfig::get('app_gerkud_izena_eta_abizena'))
			$erabiltzailea = ' concat(u.first_name, " ", coalesce(u.last_name, ""))';
		else
			$erabiltzailea = ' u.username';

		$sql = 'SELECT g.lehentasuna_id AS lehentasuna, s.name AS saila, m.izena AS mota, g.id AS kodea, e.izena AS egoera, laburpena,'
		 . ' b.izena AS barrutia, a.izena AS auzoa, er.izena AS eraikina, k.izena AS kalea, g.kale_zbkia AS zenbakia,'
		 . $erabiltzailea . ' AS erabiltzailea, abisuanork, date(g.created_at) AS irekiera_data, date(ixte_data) AS ixte_data'
		 . ' FROM gertakaria g'
		 . '  LEFT JOIN sf_guard_user u ON u.id = g.langilea_id'
		 . '  LEFT JOIN sf_guard_group_translation s ON s.id = g.saila_id AND s.lang = :hizkuntza'
		 . '  LEFT JOIN mota_translation m ON m.id = g.mota_id AND m.lang = :hizkuntza'
		 . '  LEFT JOIN egoera_translation e ON e.id = g.egoera_id AND e.lang = :hizkuntza'
		 . '  LEFT JOIN barrutia b ON b.id = g.barrutia_id'
		 . '  LEFT JOIN auzoa a ON a.id = g.auzoa_id'
		 . '  LEFT JOIN kalea k ON k.id = g.kalea_id'
		 . '  LEFT JOIN eraikina er ON er.id = g.eraikina_id';

		$parametroak = array
		(
			':hizkuntza' => $this->getUser()->getCulture()
		);

		$condiciones = array();
		$irekiera_noiztik = $this->formularioa['irekiera_noiztik'];
		if ($irekiera_noiztik)
		{
			array_push($condiciones, 'date(g.created_at) >= date(:irekiera_noiztik)');
			$parametroak[':irekiera_noiztik'] = $irekiera_noiztik;
		}
		$irekiera_nora = $this->formularioa['irekiera_nora'];
		if ($irekiera_nora)
		{
			array_push($condiciones, 'date(g.created_at) <= date(:irekiera_nora)');
			$parametroak[':irekiera_nora'] = $irekiera_nora;
		}
		$ixte_noiztik = $this->formularioa['ixte_noiztik'];
		if ($ixte_noiztik)
		{
			array_push($condiciones, 'date(g.ixte_data) >= date(:ixte_noiztik)');
			$parametroak[':ixte_noiztik'] = $ixte_noiztik;
		}
		$ixte_nora = $this->formularioa['ixte_nora'];
		if ($ixte_nora)
		{
			array_push($condiciones, 'date(g.ixte_data) <= date(:ixte_nora)');
			$parametroak[':ixte_nora'] = $ixte_nora;
		}
		$strKlasea = '';
		if ($this->formularioa['klasea'])
		{
			array_push($condiciones, 'g.klasea_id = :klasea');
			$parametroak[':klasea'] = $this->formularioa['klasea'];

			$strKlasea = Doctrine::getTable('Klasea')->find(array($this->formularioa['klasea']))->getIzena();
		}
		$strSaila = '';
		if ($this->formularioa['saila'])
		{
			array_push($condiciones, 'g.saila_id = :saila');
			$parametroak[':saila'] = $this->formularioa['saila'];

			$strSaila = Doctrine::getTable('Saila')->find(array($this->formularioa['saila']))->getName();
		}
		$strMota = '';
		if ($this->formularioa['mota_id'])
		{
			array_push($condiciones, 'g.mota_id = :mota');
			$parametroak[':mota'] = $this->formularioa['mota_id'];

			$strMota = Doctrine::getTable('Mota')->find(array($this->formularioa['mota_id']))->getIzena();
		}
		$strAzpiMota = '';
		if ($this->formularioa['azpimota_id'])
		{
			array_push($condiciones, 'g.azpimota_id = :azpimota');
			$parametroak[':azpimota'] = $this->formularioa['azpimota_id'];

			$strAzpiMota = Doctrine::getTable('Azpimota')->find(array($this->formularioa['azpimota_id']))->getIzena();
		}
		$strBarrutia = '';
		if (in_array('barrutia', $configEremuak) && $this->formularioa['barrutia'])
		{
			array_push($condiciones, 'g.barrutia_id = :barrutia');
			$parametroak[':barrutia'] = $this->formularioa['barrutia'];

			$strBarrutia = Doctrine::getTable('Barrutia')->find(array($this->formularioa['barrutia']))->getIzena();
		}
		$strAuzoa = '';
		if (in_array('auzoa', $configEremuak) && $this->formularioa['auzoa'])
		{
			array_push($condiciones, 'g.auzoa_id = :auzoa');
			$parametroak[':auzoa'] = $this->formularioa['auzoa'];

			$strAuzoa = Doctrine::getTable('Auzoa')->find(array($this->formularioa['auzoa']))->getIzena();
		}
		$strKalea = '';
		if ($this->formularioa['kalea'])
		{
			array_push($condiciones, 'g.kalea_id = :kalea');
			$parametroak[':kalea'] = $this->formularioa['kalea'];

			$strKalea = Doctrine::getTable('Kalea')->find(array($this->formularioa['kalea']))->getIzena();
		}
		$strEraikina = '';
		if ($this->formularioa['eraikina'])
		{
			array_push($condiciones, 'g.eraikina_id = :eraikina');
			$parametroak[':eraikina'] = $this->formularioa['eraikina'];

			$strEraikina = Doctrine::getTable('Eraikina')->find(array($this->formularioa['eraikina']))->getIzena();
		}
		$strEgoera = '';
		if ($this->formularioa['egoera'])
		{
			array_push($condiciones, 'g.egoera_id = :egoera');
			$parametroak[':egoera'] = $this->formularioa['egoera'];

			$strEgoera = Doctrine::getTable('Egoera')->find(array($this->formularioa['egoera']))->getIzena();
		}

		$htmlIragazkiak = '<table>';
		$htmlIragazkiak .= sprintf('<tr><td width="50"></td><td width="85">%s:</td><td width="150" style="border-bottom: 0.25px solid black;">%s</td><td width="180"></td>', __('Klasea'), $strKlasea);
		$htmlIragazkiak .= sprintf('<td width="85">%s:</td><td width="150" style="border-bottom: 0.25px solid black;">%s</td></tr>', __('Kalea'), $strKalea);
		$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Saila'), $strSaila);
		$htmlIragazkiak .= sprintf('<td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td></tr>', __('Eraikina'), $strEraikina);

		if (in_array('barrutia',$configEremuak) && in_array('auzoa',$configEremuak))
		{
			$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Barrutia'), $strBarrutia);
			$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Auzoa'), $strAuzoa);
		}
		elseif (in_array('barrutia',$configEremuak))
			$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Barrutia'), $strBarrutia);
		else
			$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Auzoa'), $strAuzoa);

		$htmlIragazkiak .= sprintf('<td>%s:</td><td style="border-bottom: 0.25px solid black;">%s%s%s</td></tr>', __('Irekiera data'), $irekiera_noiztik, !empty($irekiera_noiztik) && !empty($irekiera_nora) ? ' - ' : '', $irekiera_nora);
		$htmlIragazkiak .= sprintf('<tr><td></td><td></td><td></td><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s%s%s</td></tr>', __('Ixte data'), $ixte_noiztik, !empty($ixte_noiztik) && !empty($ixte_nora) ? ' - ' : '', $ixte_nora);
		$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s%s</td><td></td>', __('Mota'), $strMota, empty($strAzpiMota) ? '' : ' / ' . $strAzpiMota);
		$htmlIragazkiak .= sprintf('<td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td></tr>', __('Egoera'), $strEgoera);
		$htmlIragazkiak .= '</table>';

		if (count($condiciones) > 0)
			$sql .= ' WHERE ' . implode(' AND ', $condiciones);

		$orden = array();

		if (in_array('barrutia',$configEremuak) && in_array('auzoa',$configEremuak))
		{
			$SAILKAPEN_KANPOAK = array
			(
				// codigos definidos en el formulario ZerrendatuaForm.class.php
				1 => 'saila',
				2 => 'barrutia',
				3 => 'auzoa',
				4 => 'mota'
			);
		}
		elseif (in_array('barrutia',$configEremuak))
		{
			$SAILKAPEN_KANPOAK = array
			(
				1 => 'saila',
				2 => 'barrutia',
				3 => 'mota'
			);
		}
		else
		{
			$SAILKAPEN_KANPOAK = array
			(
				1 => 'saila',
				2 => 'auzoa',
				3 => 'mota'
			);
		}

		$htmlSailkapen = '<table style="text-align: right; width: 90%"><tr>' . sprintf('<td>%s:</td>', __('Sailkapena'));
		if ($this->formularioa['sailkapena1'] > 0)
		{
			array_push($orden, $SAILKAPEN_KANPOAK[$this->formularioa['sailkapena1']]);
			$htmlSailkapen .= sprintf('<td style="font-weight: bold">%s</td>', strtoupper(__(ZerrendatuaForm::$sailkapena[$this->formularioa['sailkapena1']])));
		}
		if ($this->formularioa['sailkapena2'] > 0)
		{
			array_push($orden, $SAILKAPEN_KANPOAK[$this->formularioa['sailkapena2']]);
			$htmlSailkapen .= sprintf('<td style="font-weight: bold">%s</td>', strtoupper(__(ZerrendatuaForm::$sailkapena[$this->formularioa['sailkapena2']])));
		}
		if ($this->formularioa['sailkapena3'] > 0)
		{
			array_push($orden, $SAILKAPEN_KANPOAK[$this->formularioa['sailkapena3']]);
			$htmlSailkapen .= sprintf('<td style="font-weight: bold">%s</td>', strtoupper(__(ZerrendatuaForm::$sailkapena[$this->formularioa['sailkapena3']])));
		}
		$htmlSailkapen .= '</tr></table>';

		$html = '<div style="background-color: #e8e8e8;">';

		if (count($orden) > 0)
		{
			$html .= '<br />' . $htmlSailkapen . '<br />';

			// crear ORDER BY con campos de clasificación nulos al final
			for ($i = 0; $i < count($orden); $i++)
			{
				if ($i == 0)
					$sql .= ' ORDER BY ';
				else
					$sql .= ', ';

				$sql .= sprintf('isnull(%s), %s', $orden[$i], $orden[$i]);
			}
		}

		$html .= $htmlIragazkiak;
		$html .= '</div>';

		if (sfConfig::get('app_zerrendatua_iragazkiak_erakutsi'))
			$pdf->writeHTML($html, false, false, true, false, '');

		$cn = Doctrine_Manager::getInstance()->connection();
		$cmd = $cn->prepare($sql);
		$cmd->execute($parametroak);

		// obtener datos sin indices numericos
		$gertaerak = $cmd->fetchAll(PDO::FETCH_ASSOC);
		$cmd->closeCursor();

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
			if (count($orden) >= 1 && $datuak[$orden[0]] != $sailkapen1)
			{
				$sailkapen1 = $datuak[$orden[0]];
				$goiburua1 = sprintf('<tr><td style="background-color: #aaaaaa; font-size: 34px; font-weight: bold; text-indent: 1em; vertical-align: middle; border: 1px solid black;">%s</td></tr>', $sailkapen1);
				$goiburuak .= $goiburua1;
				$aldaketak = true;
				$orriBerria = true;
			}

			if (count($orden) >= 2 && $datuak[$orden[1]] != $sailkapen2)
			{
				$sailkapen2 = $datuak[$orden[1]];
				$goiburua2 = sprintf('<tr><td style="background-color: #cccccc; font-size: 22px; font-weight: bold; text-indent: 10em">%s</td></tr>', $sailkapen2);
				$goiburuak .= $goiburua2;
				$aldaketak = true;
			}

			if (count($orden) >= 3 && $datuak[$orden[2]] != $sailkapen3)
			{
				$sailkapen3 = $datuak[$orden[2]];
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
				$izenak = '<table>'
				 . '<thead><tr style="text-decoration: underline">'
				 . '<th width="40">' . __('Kodea') . '</th>'
				 . sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
				 . '<th width="54">' . __('Egoera') . '</th>'
				 . sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
				 . '<th width="218">' . __('Laburpena') . '</th>';

				if (in_array('barrutia',sfConfig::get('app_gerkud_eremuak')) && in_array('auzoa',sfConfig::get('app_gerkud_eremuak')))
				{
					$izenak .= sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
					 . '<th width="54">' . __('Barrutia') . '</th>'
					 . sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
					 . '<th width="54">' . __('Auzoa') . '</th>';
				}
				elseif (in_array('barrutia',sfConfig::get('app_gerkud_eremuak')))
				{
					$izenak .= sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
					 . '<th width="54">' . __('Barrutia') . '</th>';
				}
				else
				{
					$izenak .= sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
					 . '<th width="54">' . __('Auzoa') . '</th>';
				}

				$izenak .= sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
				 . '<th width="150">' . __('Kalea') . ' / ' . __('Eraikina') . '</th>'
				 . sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
				 . '<th width="80">' . __('Eskatzailea') . '</th>'
				 . sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
				 . '<th width="54">' . __('Erabiltzailea') . '</th>'
				 . sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
				 . '<th width="54">' . __('Irekiera data') . '</th>'
				 . sprintf('<th width="%d"></th>', self::ZUTABE_ARTEKO_DISTANTZIA)
				 . '<th width="54">' . __('Ixte data') . '</th>'
				 . '</tr></thead>';
				$pdf->writeHTML($izenak, false, false, true, false, '');
			}

			$pdf->startTransaction();

			// nobr evita que unicamente parte de la fila pase a una nueva pagina
			$html = '<tr nobr="true">';
			$lehentasuna = "";
			switch ($datuak['lehentasuna'])
			{
				case 1:
					$lehentasuna = "";
					break;
				case 2:
					$lehentasuna = "!";
					break;
				case 3:
					$lehentasuna = "!!";
					break;
			}
			$html .= sprintf('<td width="10">%s</td>', $lehentasuna);
			$html .= sprintf('<td width="30">%s</td>', $datuak['kodea']);
			$html .= sprintf('<td width="%d"></td>', self::ZUTABE_ARTEKO_DISTANTZIA);
			$html .= sprintf('<td width="54">%s</td>', $datuak['egoera']);
			$html .= sprintf('<td width="%d"></td>', self::ZUTABE_ARTEKO_DISTANTZIA);
			$html .= sprintf('<td width="218">%s</td>', $datuak['laburpena']);
			$html .= sprintf('<td width="%d"></td>', self::ZUTABE_ARTEKO_DISTANTZIA);
			if (in_array('barrutia',sfConfig::get('app_gerkud_eremuak')) && in_array('auzoa',sfConfig::get('app_gerkud_eremuak')))
			{
				$html .= sprintf('<td width="54">%s</td>', $datuak['barrutia']);
				$html .= sprintf('<td width="54">%s</td>', $datuak['auzoa']);
			}
			elseif (in_array('barrutia',sfConfig::get('app_gerkud_eremuak')))
				$html .= sprintf('<td width="54">%s</td>', $datuak['barrutia']);
			else
				$html .= sprintf('<td width="54">%s</td>', $datuak['auzoa']);

			$html .= sprintf('<td width="%d"></td>', self::ZUTABE_ARTEKO_DISTANTZIA);
			if ($datuak['eraikina'] != null)
				$html .= sprintf('<td width="150">%s</td>', $datuak['eraikina']);
			else if ($datuak['zenbakia'] != null)
				$html .= sprintf('<td width="150">%s, %s</td>', $datuak['kalea'], $datuak['zenbakia']);
			else
				$html .= sprintf('<td width="150">%s</td>', $datuak['kalea']);
			$html .= sprintf('<td width="%d"></td>', self::ZUTABE_ARTEKO_DISTANTZIA);
			$html .= sprintf('<td width="80">%s</td>', $datuak['abisuanork']);
			$html .= sprintf('<td width="%d"></td>', self::ZUTABE_ARTEKO_DISTANTZIA);
			$html .= sprintf('<td width="54">%s</td>', $datuak['erabiltzailea']);
			$html .= sprintf('<td width="%d"></td>', self::ZUTABE_ARTEKO_DISTANTZIA);

			// no mostrar fechas sin valor
			if ($datuak['irekiera_data'] == 0)
				$html .= '<td width="54">-</td>';
			else
				$html .= sprintf('<td width="54">%s</td>', $datuak['irekiera_data']);
			$html .= sprintf('<td width="%d"></td>', self::ZUTABE_ARTEKO_DISTANTZIA);

			// no mostrar fechas sin valor
			if ($datuak['ixte_data'] == 0)
				$html .= '<td width="54">-</td>';
			else
				$html .= sprintf('<td width="54">%s</td>', $datuak['ixte_data']);
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
