<?php

// PDFan data ezartzeko
class GerkudPDF extends TCPDF
{
	public function Header()
	{
		$headerfont = $this->getHeaderFont();
		$headerdata = $this->getHeaderData();
		$this->y = $this->header_margin;
		if ($this->rtl)
			$this->x = $this->w - $this->original_rMargin;
		else
			$this->x = $this->original_lMargin;

		if (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE))
		{
			$imgtype = $this->getImageFileType(K_PATH_IMAGES.$headerdata['logo']);
			if (($imgtype == 'eps') OR ($imgtype == 'ai'))
				$this->ImageEps(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
			elseif ($imgtype == 'svg')
				$this->ImageSVG(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);
			else
				$this->Image(K_PATH_IMAGES.$headerdata['logo'], '', '', $headerdata['logo_width']);

			$imgy = $this->getImageRBY();
		}
		else
			$imgy = $this->y;

		$cell_height = round(($this->cell_height_ratio * $headerfont[2]) / $this->k, 2);
		// set starting margin for text data cell
		if ($this->getRTL())
			$header_x = $this->original_rMargin + ($headerdata['logo_width'] * 1.1);
		else
			$header_x = $this->original_lMargin + ($headerdata['logo_width'] * 1.1);

		$cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($headerdata['logo_width'] * 1.1);
		$this->SetTextColor(0, 0, 0);
		// header title
		$this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
		$this->SetX($header_x);
		$this->Cell($cw, $cell_height * 2, $headerdata['title'], 0, 1, '', 0, '', 0, '', '',  'B');
		// header string
		$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
		$this->SetX($header_x);
		$this->MultiCell($cw, $cell_height, $headerdata['string'], 0, '', 0, 0, '', '', true, 0, false, true, $cell_height, 'T', false);
		$this->SetFont($headerfont[0], '', $headerfont[2] + 1);
		$this->Cell(0, 10, date("Y/m/d"), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		// print an ending header line
		$this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetY((2.835 / $this->k) + max($imgy, $this->y));
		if ($this->rtl)
			$this->SetX($this->original_rMargin);
		else
			$this->SetX($this->original_lMargin);

		$this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
		$this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
	}

	public function Footer()
	{
		$this->Cell(0, 10, sprintf('%s/%s', $this->getAliasNumPage(), $this->getAliasNbPages()), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}
