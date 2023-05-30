<?php

/**
 * Gertakaria filter form.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GertakariaFormFilter extends BaseGertakariaFormFilter
{
	public function configure()
	{
		$culture = sfContext::getInstance()->getUser()->getCulture();

		// Testu librerako bilaketa
		$this->widgetSchema['librea'] = new sfWidgetFormFilterInput(array('with_empty' => false));
		$this->validatorSchema['librea'] = new sfValidatorPass(array
		(
			'required' => false
		));

 		$this->widgetSchema['id'] = new sfWidgetFormFilterInput(array
		(
			'with_empty' => false,
		));
		$this->validatorSchema['id'] = new sfValidatorPass(array
		(
			'required' => false
		));

		$this->widgetSchema['created_at_noiztik'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['created_at_noiztik'] = new sfValidatorDataOrdua(array('required' => false));

		$this->widgetSchema['created_at_nora'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['created_at_nora'] = new sfValidatorDataOrdua(array('required' => false));

		$this->widgetSchema['ixte_data_noiztik'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['ixte_data_noiztik'] = new sfValidatorDataOrdua(array('required' => false));

		$this->widgetSchema['ixte_data_nora'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['ixte_data_nora'] = new sfValidatorDataOrdua(array('required' => false));

		$this->widgetSchema['hasiera_aurreikusia_noiztik'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['hasiera_aurreikusia_noiztik'] = new sfValidatorDataOrdua(array('required' => false));

		$this->widgetSchema['hasiera_aurreikusia_nora'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['hasiera_aurreikusia_nora'] = new sfValidatorDataOrdua(array('required' => false));

		$this->widgetSchema['amaiera_aurreikusia_noiztik'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['amaiera_aurreikusia_noiztik'] = new sfValidatorDataOrdua(array('required' => false));

		$this->widgetSchema['amaiera_aurreikusia_nora'] = new sfWidgetFormData(array
		(
		));
		$this->validatorSchema['amaiera_aurreikusia_nora'] = new sfValidatorDataOrdua(array('required' => false));

		$this->widgetSchema['barrutia_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Barrutia',
			'add_empty' => '--',
		));

		$this->widgetSchema['auzoa_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Auzoa',
			'add_empty' => '--',
		));

		$this->widgetSchema['kalea_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Kalea',
			'add_empty' => '--',
			'order_by'  => array('izena','asc')
		));

		$this->widgetSchema['kale_zbkia'] = new sfWidgetFormFilterInput(array
		(
			'with_empty' => false,
		));
		$this->validatorSchema['kale_zbkia'] = new sfValidatorPass(array
		(
			'required' => false
		));

		$this->widgetSchema['mota_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Mota',
			'add_empty' => '--',
			'query'     => Doctrine_Core::getTable('Mota')->createQuery('m')->leftJoin('m.Translation t WITH t.lang = ?', $culture)->orderBy('t.izena ASC')
		));

		$this->widgetSchema['azpimota_id'] = new sfWidgetFormDoctrineDependentSelect(array
		(
			'model'        => 'Azpimota',
			'depends'      => 'Mota',
			'add_empty'    => '--',
			'table_method' => 'getAzpimotaQuery',
			'order_by'     => array('izena', 'ASC')
		));

		$this->widgetSchema['klasea_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Klasea',
			'add_empty' => '--',
			'query'     => Doctrine_Core::getTable('Klasea')->createQuery('k')->leftJoin('k.Translation t WITH t.lang = ?', $culture)->orderBy('t.izena ASC')
		));

		$this->widgetSchema['arloa_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Arloa',
			'add_empty' => '--',
			'query'     => Doctrine_Core::getTable('Arloa')->createQuery('a')->leftJoin('a.Translation t WITH t.lang = ?', $culture)->orderBy('t.izena ASC')
		));

		$this->widgetSchema['egoera_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Egoera',
			'add_empty' => '--',
			'query'     => Doctrine_Core::getTable('Egoera')->createQuery('e')->leftJoin('e.Translation t WITH t.lang = ?', $culture)->orderBy('t.izena ASC')
		));

		$this->widgetSchema['saila_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Saila',
			'add_empty' => '--',
			'query'     => Doctrine_Core::getTable('Saila')->createQuery('s')->leftJoin('s.Translation t WITH t.lang = ?', $culture)->orderBy('t.name ASC')
		));

		$this->widgetSchema['eraikina_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'Eraikina',
			'add_empty' => '--',
			'order_by'  => array('izena','asc')
		));

		$this->widgetSchema['jatorrizkoSaila_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model'     => 'JatorrizkoSaila',
			'add_empty' => '--',
			'query'     => Doctrine_Core::getTable('JatorrizkoSaila')->createQuery('j')->leftJoin('j.Translation t WITH t.lang = ?', $culture)->orderBy('t.izena ASC')
		));

		$this->widgetSchema['espedientea'] = new sfWidgetFormFilterInput(array
		(
			'with_empty' => false,
		));
	}
}
