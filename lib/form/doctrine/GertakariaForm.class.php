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
		$configEremuak = sfConfig::get('gerkud_eremuak_gaituak');
		$configDerrigorrezkoak = sfConfig::get('gerkud_eremuak_derrigorrezkoak');
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
		else
		{
			$this->widgetSchema['kalea_id'] = new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Kalea',
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
			'query' => Doctrine_Core::getTable('Mota')->createQuery('m')
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
			'required' => (in_array('laburpena', $configDerrigorrezkoak)) ? true : false,
			'max_length' => 250
		),
		array
		(
			'max_length' => 'Idatzitako testua luzeegia da.'
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
			'query' => Doctrine_Core::getTable('JatorrizkoSaila')
				->createQuery('j')
				->leftJoin('j.Translation t WITH t.lang = ?', $culture)
				->orderBy('t.izena ASC')
		));
		$this->validatorSchema['jatorrizkoSaila_id'] = new sfValidatorDoctrineChoice(array
		(
			'model' => 'JatorrizkoSaila',
			'required' => (in_array('jatorrizkosaila', $configDerrigorrezkoak)) ? true : false
		));

		$this->validatorSchema['espedientea'] = new sfValidatorString(array
		(
			'required' => (in_array('espedientea', $configDerrigorrezkoak)) ? true : false,
			'max_length' => 12
		));

		$this->widgetSchema['klasea_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model' => 'Klasea',
			'add_empty' => '--',
			'query' => Doctrine_Core::getTable('Klasea')
				->createQuery('k')
				->leftJoin('k.Translation t WITH t.lang = ?', $culture)
				->orderBy('t.izena ASC')
		));
		$this->validatorSchema['klasea_id'] = new sfValidatorDoctrineChoice(array
		(
			'model' => 'Klasea',
			'required' => (in_array('klasea', $configDerrigorrezkoak)) ? true : false
		));

		$this->widgetSchema['arloa_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model' => 'Arloa',
			'add_empty' => '--',
			'query' => Doctrine_Core::getTable('Arloa')
				->createQuery('a')
				->leftJoin('a.Translation t WITH t.lang = ?', $culture)
				->orderBy('t.izena ASC')
		));
		$this->validatorSchema['arloa_id'] = new sfValidatorDoctrineChoice(array
		(
			'model' => 'Arloa',
			'required' => (in_array('arloa', $configDerrigorrezkoak)) ? true : false
		));

		if (in_array('lehentasuna', $configDerrigorrezkoak))
		{
			$this->widgetSchema['lehentasuna_id'] = new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Lehentasuna',
				'add_empty' => false,
				'query' => Doctrine_Core::getTable('Lehentasuna')
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
				'query' => Doctrine_Core::getTable('Lehentasuna')
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

		if (sfConfig::get('gerkud_sortze_data_automatikoa'))
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

		if (!in_array('abisuanork', $configEremuak))
			unset($this['abisuaNork']);

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

		$this->embedRelation('Kontaktua');
	}

	public function postValidate($validator, $values)
	{
		// la variable 'created_at' del array '$values' solo lo envia la fecha de creacion no es automatica
		if (!array_key_exists('created_at', $values))
		{
			if ($this->getObject()->getCreatedAt() == null)
				$sortze_data = date("Y-m-d");
			else
				$sortze_data = strftime("%Y-%m-%d", strtotime($this->getObject()->getCreatedAt()));
		}
		else
			$sortze_data = strftime("%Y-%m-%d", strtotime($values["created_at"]));

		if (sfConfig::get('gerkud_balidazioak_aurreikuspen_datak'))
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
