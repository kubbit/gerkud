<?php

/**
 * Gertakaria form.
 *
 * @package    gerkud
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GertakariaForm extends BaseGertakariaForm
{
	public function configure()
	{
		$culture = sfContext::getInstance()->getUser()->getCulture();

		$this->widgetSchema['barrutia_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Barrutia',
			'add_empty' => '--',
			'order_by'  => array('izena', 'ASC')
		));

		$this->widgetSchema['kalea_id'] = new sfWidgetFormDoctrineDependentSelect(array
		(
			'model'     => 'Kalea',
			'depends'   => 'Barrutia',
			'add_empty' => '--',
			'order_by'  => array('izena', 'ASC')
		));
		$this->widgetSchema['mota_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Mota',
			'add_empty' => '--',
			'query'     => Doctrine::getTable('Mota')->createQuery('m')
			                                         ->select('m.id, t.izena')
			                                         ->leftJoin('m.Translation t WITH t.lang = ?', $culture)
			                                         ->orderBy('t.izena ASC'),
			'order_by' => array('izena', 'ASC')
		));

		$this->widgetSchema['laburpena'] = new sfWidgetFormTextarea(array
		(
		));

		$this->validatorSchema['laburpena'] = new sfValidatorString(array('required' => true));

		$this->widgetSchema['deskribapena'] = new sfWidgetFormTextarea(array
		(
		));

		$this->validatorSchema['deskribapena'] = new sfValidatorString(array('required' => false));

		$this->widgetSchema['azpimota_id'] = new sfWidgetFormDoctrineDependentSelect(array
		(
			'model'        => 'Azpimota',
			'depends'      => 'mota_id',
			'add_empty'    => '--',
			'table_method' => 'getAzpimotaQuery',
			'order_by'     => array('izena', 'ASC')
		));

		$this->widgetSchema['eraikina_id'] = new sfWidgetFormDoctrineDependentSelect(array
		(
			'model'     => 'Eraikina',
			'depends'   => 'Barrutia',
			'add_empty' => '--',
			'order_by'  => array('izena', 'ASC')
		));

		$this->widgetSchema['jatorrizkoSaila_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'JatorrizkoSaila',
			'add_empty' => '--',
			'query'     => Doctrine::getTable('JatorrizkoSaila')->createQuery('j')
			                                                    ->leftJoin('j.Translation t WITH t.lang = ?', $culture)
			                                                    ->orderBy('t.izena ASC')
		));

		$this->widgetSchema['klasea_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Klasea',
			'add_empty' => '--',
			'query'     => Doctrine::getTable('Klasea')->createQuery('k')
			                                           ->leftJoin('k.Translation t WITH t.lang = ?', $culture)
			                                           ->orderBy('t.izena ASC')
		));

		$this->widgetSchema['hasiera_aurreikusia'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['hasiera_aurreikusia'] = new sfValidatorDataOrdua(array('required' => false));

		$this->widgetSchema['amaiera_aurreikusia'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['amaiera_aurreikusia'] = new sfValidatorDataOrdua(array('required' => false));

		if (sfConfig::get('app_sortze_data_automatikoa'))
		{
			unset($this['created_at']);
		}
		else
		{
			$this->widgetSchema['created_at'] = new sfWidgetFormDataOrdua(array
			(
				'type' => 'datetime',
				'default' => new DateTime()
			));

			$this->validatorSchema['created_at'] = new sfValidatorDataOrdua(array('required' => true));
		}

		unset
		(
			$this['updated_at']
		);

		$this->validatorSchema->setPostValidator
		(
			new sfValidatorCallback(array('callback' => array($this, 'postValidate')))
		);
	}

	protected function doUpdateObject($values)
	{
		parent::doUpdateObject($values);

		// establecer el resumen como descripcion si no ha sido rellenado
		if (!isset($values['deskribapena']) || $values['deskribapena'] == '')
			$this->getObject()->setDeskribapena($values['laburpena']);
	}

	public function postValidate($validator, $values)
	{
		if (sfConfig::get('app_sortze_data_automatikoa') || $values["created_at"] == null)
			$sortze_data = date("Y-m-d");
		else
			$sortze_data = strftime("%Y-%m-%d", strtotime($values["created_at"]));

		if (sfConfig::get('app_balidatu_aurreikuspen_datak'))
		{
			if ($values["hasiera_aurreikusia"] != null && strtotime($values["hasiera_aurreikusia"]) < strtotime($sortze_data))
			{
				$error = new sfValidatorError($validator, "Hasiera data ezin da irekierakoa baino lehenagokoa izan");
				throw new sfValidatorErrorSchema($validator, array('hasiera_aurreikusia' => $error));
			}

			if ($values["amaiera_aurreikusia"] != null && strtotime($values["amaiera_aurreikusia"]) < strtotime($values["hasiera_aurreikusia"]))
			{
				$error = new sfValidatorError($validator, "Amaiera data ezin da hasierakoa baino lehenagokoa izan");
				throw new sfValidatorErrorSchema($validator, array('amaiera_aurreikusia' => $error));
			}
		}

		return $values;
	}
}
