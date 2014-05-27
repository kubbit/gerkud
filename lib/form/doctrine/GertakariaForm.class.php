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
		$configEremuak = sfConfig::get('app_gerkud_eremuak');
		$configDerrigorrezkoak = sfConfig::get('app_gerkud_derrigorrezkoak');
		$culture = sfContext::getInstance()->getUser()->getCulture();

		$this->widgetSchema['saila_id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['langilea_id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['ixte_data'] = new sfWidgetFormInputHidden();

		$this->widgetSchema['barrutia_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model' => 'Barrutia',
			'add_empty' => '--',
			'order_by' => array('izena', 'ASC')
		));
		$this->validatorSchema['barrutia_id'] = new sfValidatorDoctrineChoice(array
		(
			'model' => 'Barrutia',
			'required' => (in_array('barrutia', $configDerrigorrezkoak)) ? true : false
		));

		if (in_array('barrutia', $configEremuak) && in_array('auzoa', $configEremuak))
		{
			$this->widgetSchema['auzoa_id'] = new sfWidgetFormDoctrineDependentSelect(array
			(
				'model' => 'Auzoa',
				'depends' => 'Barrutia',
				'add_empty' => '--',
				'order_by' => array('izena', 'ASC')
			));
			$this->validatorSchema['auzoa_id'] = new sfValidatorDoctrineChoice(array
			(
				'model' => 'Auzoa',
				'required' => (in_array('auzoa', $configDerrigorrezkoak)) ? true : false
			));

			$this->widgetSchema['kalea_id'] = new sfWidgetFormDoctrineDependentSelect(array
			(
				'model' => 'Kalea',
				'depends' => 'Auzoa',
				'add_empty' => '--',
				'order_by' => array('izena', 'ASC')
			));
			$this->validatorSchema['kalea_id'] = new sfValidatorDoctrineChoice(array
			(
				'model' => 'Kalea',
				'required' => (in_array('kalea', $configDerrigorrezkoak)) ? true : false
			));
		}
		elseif (in_array('barrutia', $configEremuak))
		{
			$this->widgetSchema['kalea_id'] = new sfWidgetFormDoctrineDependentSelect(array
			(
				'model' => 'Kalea',
				'depends' => 'Barrutia',
				'add_empty' => '--',
				'order_by' => array('izena', 'ASC')
			));
			$this->validatorSchema['kalea_id'] = new sfValidatorDoctrineChoice(array
			(
				'model' => 'Kalea',
				'required' => (in_array('kalea', $configDerrigorrezkoak)) ? true : false
			));
		}
		elseif (in_array('auzoa', $configEremuak))
		{
			$this->widgetSchema['auzoa_id'] = new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Auzoa',
				'add_empty' => '--',
				'order_by' => array('izena', 'ASC')
			));
			$this->validatorSchema['auzoa_id'] = new sfValidatorDoctrineChoice(array
			(
				'model' => 'Auzoa',
				'required' => (in_array('auzoa', $configDerrigorrezkoak)) ? true : false
			));

			$this->widgetSchema['kalea_id'] = new sfWidgetFormDoctrineDependentSelect(array
			(
				'model' => 'Kalea',
				'depends' => 'Auzoa',
				'add_empty' => '--',
				'order_by' => array('izena', 'ASC')
			));
			$this->validatorSchema['kalea_id'] = new sfValidatorDoctrineChoice(array
			(
				'model' => 'Kalea',
				'required' => (in_array('kalea', $configDerrigorrezkoak)) ? true : false
			));
		}

		if (in_array('barrutia', $configEremuak))
		{
			$this->widgetSchema['eraikina_id'] = new sfWidgetFormDoctrineDependentSelect(array
			(
				'model' => 'Eraikina',
				'depends' => 'Barrutia',
				'add_empty' => '--',
				'order_by' => array('izena', 'ASC')
			));
		}
		elseif (in_array('auzoa', $configEremuak))
		{
			$this->widgetSchema['eraikina_id'] = new sfWidgetFormDoctrineDependentSelect(array
			(
				'model' => 'Eraikina',
				'depends' => 'Auzoa',
				'add_empty' => '--',
				'order_by' => array('izena', 'ASC')
			));
		}
		else
		{
			$this->widgetSchema['eraikina_id'] = new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Eraikina',
				'add_empty' => '--',
				'order_by' => array('izena', 'ASC')
			));
		}
		$this->validatorSchema['eraikina_id'] = new sfValidatorDoctrineChoice(array
		(
			'model' => 'Eraikina',
			'required' => (in_array('eraikina', $configDerrigorrezkoak)) ? true : false
		));

		$this->validatorSchema['kale_zbkia'] = new sfValidatorString(array
		(
			'required' => (in_array('kale_zbkia', $configDerrigorrezkoak)) ? true : false
		));

		$this->widgetSchema['mota_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model' => 'Mota',
			'add_empty' => '--',
			'query' => Doctrine::getTable('Mota')->createQuery('m')
				->select('m.id, t.izena')
				->leftJoin('m.Translation t WITH t.lang = ?', $culture)
				->orderBy('t.izena ASC'),
			'order_by' => array('izena', 'ASC')
		));
		$this->validatorSchema['mota_id'] = new sfValidatorDoctrineChoice(array
		(
			'model' => 'Mota',
			'required' => (in_array('mota', $configDerrigorrezkoak)) ? true : false
		));

		$this->validatorSchema['abisuaNork'] = new sfValidatorString(array
		(
			'required' => (in_array('abisuanork', $configDerrigorrezkoak)) ? true : false
		));

		$this->widgetSchema['laburpena'] = new sfWidgetFormTextarea(array
		(
		));
		$this->validatorSchema['laburpena'] = new sfValidatorString(array
		(
			'required' => (in_array('laburpena', $configDerrigorrezkoak)) ? true : false
		));

		$this->widgetSchema['deskribapena'] = new sfWidgetFormTextarea(array
		(
		));
		$this->validatorSchema['deskribapena'] = new sfValidatorString(array
		(
			'required' => (in_array('deskribapena', $configDerrigorrezkoak)) ? true : false
		));

		$this->widgetSchema['azpimota_id'] = new sfWidgetFormDoctrineDependentSelect(array
		(
			'model' => 'Azpimota',
			'depends' => 'mota_id',
			'add_empty' => '--',
			'table_method' => 'getAzpimotaQuery',
			'order_by' => array('izena', 'ASC')
		));
		$this->validatorSchema['azpimota_id'] = new sfValidatorDoctrineChoice(array
		(
			'model' => 'Azpimota',
			'required' => (in_array('azpimota', $configDerrigorrezkoak)) ? true : false
		));

		$this->widgetSchema['jatorrizkoSaila_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model' => 'JatorrizkoSaila',
			'add_empty' => '--',
			'query' => Doctrine::getTable('JatorrizkoSaila')
				->createQuery('j')
				->leftJoin('j.Translation t WITH t.lang = ?', $culture)
				->orderBy('t.izena ASC')
		));
		$this->validatorSchema['jatorrizkoSaila_id'] = new sfValidatorDoctrineChoice(array
		(
			'model' => 'JatorrizkoSaila',
			'required' => (in_array('jatorrizkosaila', $configDerrigorrezkoak)) ? true : false
		));

		$this->widgetSchema['klasea_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model' => 'Klasea',
			'add_empty' => '--',
			'query' => Doctrine::getTable('Klasea')
				->createQuery('k')
				->leftJoin('k.Translation t WITH t.lang = ?', $culture)
				->orderBy('t.izena ASC')
		));
		$this->validatorSchema['klasea_id'] = new sfValidatorDoctrineChoice(array
		(
			'model' => 'Klasea',
			'required' => (in_array('klasea', $configDerrigorrezkoak)) ? true : false
		));

		if (in_array('lehentasuna', $configDerrigorrezkoak))
		{
			$this->widgetSchema['lehentasuna_id'] = new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Lehentasuna',
				'add_empty' => false,
				'query' => Doctrine::getTable('Lehentasuna')
					->createQuery('k')
					->leftJoin('k.Translation t WITH t.lang = ?', $culture)
			));
			$this->validatorSchema['lehentasuna_id'] = new sfValidatorDoctrineChoice(array
			(
				'model' => 'Lehentasuna',
				'required' => true
			));
		}
		else
		{
			$this->widgetSchema['lehentasuna_id'] = new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Lehentasuna',
				'add_empty' => '--',
				'query' => Doctrine::getTable('Lehentasuna')
					->createQuery('k')
					->leftJoin('k.Translation t WITH t.lang = ?', $culture)
			));
			$this->validatorSchema['lehentasuna_id'] = new sfValidatorDoctrineChoice(array
			(
				'model' => 'Lehentasuna',
				'required' => false
			));
		}

		$this->widgetSchema['hasiera_aurreikusia'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['hasiera_aurreikusia'] = new sfValidatorDataOrdua(array
		(
			'required' => (in_array('hasiera_aurreikusia', $configDerrigorrezkoak)) ? true : false
		));

		$this->widgetSchema['amaiera_aurreikusia'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['amaiera_aurreikusia'] = new sfValidatorDataOrdua(array
		(
			'required' => (in_array('amaiera_aurreikusia', $configDerrigorrezkoak)) ? true : false
		));

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
			$this['updated_at'],
			$this['herritarrena'],
			$this['kontaktua_id']
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
