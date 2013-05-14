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

// PDF-aren oinan sortze data ezartzeko
class ZerrendaPDF extends TCPDF
{
	public function Footer()
	{
		$this->Cell(0, 10, date("Y/m/d"), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(0, 10, sprintf('%s/%s', $this->getAliasNumPage(), $this->getAliasNbPages()), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}

class zerrendatuActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->zerrendatuaForm = new ZerrendatuaForm();

		$this->formularioa = $request->getParameter('zerrendatu');
		if ($this->formularioa)
			$this->inprimatu();
	}
	public function inprimatu()
	{
		$config = sfYaml::load(sfConfig::get("sf_app_config_dir") . '/pdf_configs.yml');
		// 'L' = Landscape orientation
		$pdf = new ZerrendaPDF('L');
		$pdf->SetFont('FreeSerif', '', 10);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

		$html = '<html><head></head><body>';

		$sql = 'SELECT s.name AS saila, m.izena AS mota, g.id AS kodea, e.izena AS egoera, laburpena,'
		 . ' b.izena AS barrutia, er.izena AS eraikina, k.izena AS kalea, g.kale_zbkia AS zenbakia,'
		 . ' u.username AS erabiltzailea, abisuanork, date(g.created_at) AS irekiera_data, date(ixte_data) AS ixte_data'
		 . ' FROM gertakaria g'
		 . '  LEFT JOIN sf_guard_user u ON u.id = g.langilea_id'
		 . '  LEFT JOIN sf_guard_group_translation s ON s.id = g.saila_id AND s.lang = :hizkuntza'
		 . '  LEFT JOIN mota_translation m ON m.id = g.mota_id AND m.lang = :hizkuntza'
		 . '  LEFT JOIN egoera_translation e ON e.id = g.egoera_id AND e.lang = :hizkuntza'
		 . '  LEFT JOIN barrutia b ON b.id = g.barrutia_id'
		 . '  LEFT JOIN kalea k ON k.id = g.kalea_id'
		 . '  LEFT JOIN eraikina er ON er.id = g.eraikina_id';

		$parametroak = array
		(
			':hizkuntza' => $this->getUser()->getCulture()
		);

		$condiciones = array();
		$hasiera = $this->widget2date($this->formularioa['hasiera']);
		if ($hasiera)
		{
			array_push($condiciones, 'date(g.created_at) >= date(:hasiera)');
			$parametroak[':hasiera'] = $hasiera;
		}
		$amaiera = $this->widget2date($this->formularioa['amaiera']);
		if ($amaiera)
		{
			array_push($condiciones, 'date(g.created_at) <= date(:amaiera)');
			$parametroak[':amaiera'] = $amaiera;
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
		if ($this->formularioa['barrutia'])
		{
			array_push($condiciones, 'g.barrutia_id = :barrutia');
			$parametroak[':barrutia'] = $this->formularioa['barrutia'];

			$strBarrutia = Doctrine::getTable('Barrutia')->find(array($this->formularioa['barrutia']))->getIzena();
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
		$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td><td></td>', __('Auzoa'), $strBarrutia);
		$htmlIragazkiak .= sprintf('<td>%s:</td><td style="border-bottom: 0.25px solid black;">%s%s%s</td></tr>', __('Data tartea'), $hasiera, !empty($hasiera) && !empty($amaiera) ? ' - ' : '', $amaiera);
		$htmlIragazkiak .= sprintf('<tr><td></td><td>%s:</td><td style="border-bottom: 0.25px solid black;">%s%s</td><td></td>', __('Mota'), $strMota, empty($strAzpiMota) ? '' :  ' / ' . $strAzpiMota);
		$htmlIragazkiak .= sprintf('<td>%s:</td><td style="border-bottom: 0.25px solid black;">%s</td></tr>', __('Egoera'), $strEgoera);
		$htmlIragazkiak .= '</table>';

		if (count($condiciones) > 0)
			$sql .= ' WHERE ' . implode(' AND ', $condiciones);

		$orden = array();
		$SAILKAPEN_KANPOAK = array
		(
		    // codigos definidos en el formulario ZerrendatuaForm.class.php
		    1 => 'saila',
		    2 => 'barrutia',
		    3 => 'mota'
		);

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

		$html .= '<div style="background-color: #e8e8e8;">';
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

		$cn = Doctrine_Manager::getInstance()->connection();
		$cmd = $cn->prepare($sql);
		$cmd->execute($parametroak);

		// obtener datos sin indices numericos
		$gertaerak = $cmd->fetchAll(PDO::FETCH_ASSOC);
		$cmd->closeCursor();

		$sailkapen1 = '-';
		$sailkapen2 = '-';
		$sailkapen3 = '-';
		$lehenTaula = true;
		foreach ($gertaerak as $datuak)
		{
			$aldaketak = false;
			$orriBerria = false;
			$goiburua = '';
			if (count($orden) >= 1 && $datuak[$orden[0]] != $sailkapen1)
			{
				$sailkapen1 = $datuak[$orden[0]];
				$goiburua .= sprintf('<tr><td style="background-color: #aaaaaa; font-size: 34px; font-weight: bold; text-indent: 1em; vertical-align: middle; border: 1px solid black;">%s</td></tr>', $sailkapen1);
				$aldaketak = true;
				$orriBerria = true;
			}

			if (count($orden) >= 2 && $datuak[$orden[1]] != $sailkapen2)
			{
				$sailkapen2 = $datuak[$orden[1]];
				$goiburua .= sprintf('<tr><td style="background-color: #cccccc; font-size: 22px; font-weight: bold; text-indent: 10em">%s</td></tr>', $sailkapen2);
				$aldaketak = true;
			}

			if (count($orden) >= 3 && $datuak[$orden[2]] != $sailkapen3)
			{
				$sailkapen3 = $datuak[$orden[2]];
				$goiburua .= sprintf('<tr><td style="background-color: #e8e8e8; font-style: italic; text-indent: 20em">%s</td></tr>', $sailkapen3);
				$aldaketak = true;
			}

			if ($aldaketak || $lehenTaula)
			{
				if (!$lehenTaula)
				{
					$html .= '</table>';

					if ($orriBerria)
						$html .= '<br pagebreak="true" />';
				}

				if ($aldaketak)
					$html .= '<table>' . $goiburua . '</table>';

				$lehenTaula = false;

				$html .= '<table>'
				 . '<thead><tr style="text-decoration: underline">'
				 . '<td width="30">' . __('Kodea') . '</td>'
				 . '<td width="54">' . __('Egoera') . '</td>'
				 . '<td width="228">' . __('Laburpena') . '</td>'
				 . '<td width="54">' . __('Auzoa') . '</td>'
				 . '<td width="150">' . __('Kalea') . ' / ' . __('Eraikina') . '</td>'
				 . '<td width="80">' . __('Eskatzailea') . '</td>'
				 . '<td width="54">' . __('Erabiltzailea') . '</td>'
				 . '<td width="54">' . __('Irekiera data') . '</td>'
				 . '<td width="54">' . __('Ixte data') . '</td>'
				 . '</tr></thead>';
			}

			$html .= '<tr>';
			$html .= sprintf('<td width="30">%s</td>', $datuak['kodea']);
			$html .= sprintf('<td width="54">%s</td>', $datuak['egoera']);
			$html .= sprintf('<td width="228">%s</td>', $datuak['laburpena']);
			$html .= sprintf('<td width="54">%s</td>', $datuak['barrutia']);
			if ($datuak['eraikina'] != null)
				$html .= sprintf('<td width="150">%s</td>', $datuak['eraikina']);
			else if ($datuak['zenbakia'] != null)
				$html .= sprintf('<td width="150">%s, %s</td>', $datuak['kalea'], $datuak['zenbakia']);
			else
				$html .= sprintf('<td width="150">%s</td>', $datuak['kalea']);
			$html .= sprintf('<td width="80">%s</td>', $datuak['abisuanork']);
			$html .= sprintf('<td width="54">%s</td>', $datuak['erabiltzailea']);

			// no mostrar fechas sin valor
			if ($datuak['irekiera_data'] == 0)
				$html .= '<td width="54">-</td>';
			else
				$html .= sprintf('<td width="54">%s</td>', $datuak['irekiera_data']);

			// no mostrar fechas sin valor
			if ($datuak['ixte_data'] == 0)
				$html .= '<td width="54">-</td>';
			else
				$html .= sprintf('<td width="54">%s</td>', $datuak['ixte_data']);
			$html .= '</tr>';
		}
		if ($gertaerak)
			$html .= '</table>';

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->Output();

		// Stop symfony process
		throw new sfStopException();
	}
	protected function widget2date($widget)
	{
		if ($widget['year'] == null || $widget['month'] == null || $widget['day'] == null)
			return null;

		return sprintf('%04d-%02d-%02d', $widget['year'], $widget['month'], $widget['day']);
	}
}
