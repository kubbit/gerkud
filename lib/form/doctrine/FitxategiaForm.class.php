<?php

/**
 * Fitxategia form.
 *
 * @package    gerkud
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FitxategiaForm extends BaseFitxategiaForm
{
	public function configure()
	{
		$this->validatorSchema->setOption('allow_extra_fields', true);

		$this->widgetSchema['fitxategia2'] = new sfWidgetFormInputFile(array
		(
			'label' => 'Fitxategia',
		));

		$this->validatorSchema['fitxategia2'] = new sfValidatorFile(array
		(
			'required' => false,
			'path' => sfConfig::get('sf_upload_dir') . '/FILES/',
//			'mime_types' => array('application/pdf'),
		));

		$this->widgetSchema['gertakaria_id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['langilea_id'] = new sfWidgetFormInputHidden();

		unset
		(
			$this['created_at'], $this['updated_at'], $this['fitxategia']
		);
	}

	public function save($con = null)
	{
		$gertakaria = $this['gertakaria_id']->getValue();
		$langilea = $this['langilea_id']->getValue();
		$file = $this->getValue('fitxategia2');
		if ($file)
		{
			$filename = $file->getOriginalName();

			$filename2 = $filename;
			$i = 1;
			while (file_exists(sfConfig::get('sf_upload_dir') . '/FILES/' . $gertakaria . '/' . $filename2))
			{
				$filename2 = str_replace(".", "(" . $i . ").", $filename);
				echo $filename2;
				$i++;
			}
			$filename = $filename2;

			$file->save(sfConfig::get('sf_upload_dir') . '/FILES/' . $gertakaria . '/' . $filename);
			$fitxategia = $filename;

			$izena = $this['deskribapena']->getValue();

			$temp = array('gertakaria_id' => $gertakaria, 'langilea_id' => $langilea, 'fitxategia' => $fitxategia, 'deskribapena' => $izena);

			$this->updateObject($temp);
			$this->getObject()->save($con);

			return $this->getObject();
		}
	}
}
