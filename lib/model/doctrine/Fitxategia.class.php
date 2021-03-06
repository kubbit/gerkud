<?php

/**
 * Fitxategia
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    gerkud
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Fitxategia extends BaseFitxategia
{
	protected $edukia;

	public function setEdukia($value)
	{
		$this->edukia = base64_decode($value);
	}

	public function save(Doctrine_Connection $conn = null)
	{
		if ($this->edukia)
		{
			$izena = $this->getFitxategia();
			$i = 1;
			$direktorioa = sprintf('%s/FILES/%d/', sfConfig::get('sf_upload_dir'), $this->getGertakariaId());
			while (file_exists($direktorioa . $izena))
			{
				$izena = str_replace(".", "(" . $i . ").", $this->getFitxategia());
				$i++;
			}

			if (!is_dir($direktorioa))
				mkdir($direktorioa);
			file_put_contents($direktorioa . $izena, $this->edukia);
		}

		$conn = $conn ? $conn : Doctrine_Core::getTable('Fitxategia')->getConnection();
		$conn->beginTransaction();
		try
		{
			$ret = parent::save($conn);
			$conn->commit();

			return $ret;
		}
		catch (Exception $e)
		{
			$conn->rollBack();
			throw $e;
		}
	}
}
