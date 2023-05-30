<?php

/**
 * Gertakari zerrendatua
 *
 * @package    gerkud
 * @subpackage form
 * @author     Kubbit Information Technology
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class ZerrendatuaForm extends sfForm
{
	public static $sailkapena;

	public function configure()
	{
		$culture = sfContext::getInstance()->getUser()->getCulture();

		if (in_array('barrutia',sfConfig::get('gerkud_eremuak_gaituak')) && in_array('auzoa',sfConfig::get('gerkud_eremuak_gaituak')))
			$sailkapen = array(-1 => '--', 1 => 'Saila', 2 => 'Barrutia', 3 => 'Auzoa', 4 => 'Mota');
		elseif (in_array('barrutia',sfConfig::get('gerkud_eremuak_gaituak')))
			$sailkapen = array(-1 => '--', 1 => 'Saila', 2 => 'Barrutia', 3 => 'Mota');
		else
			$sailkapen = array(-1 => '--', 1 => 'Saila', 2 => 'Auzoa', 3 => 'Mota');

		self::$sailkapena = $sailkapen;

		$this->setWidgets(array
		(
			'sailkapena' => new sfWidgetFormSelect(array
			(
				'choices' => self::$sailkapena
			)),
			'irekiera_noiztik' => new sfWidgetFormData(array
			(
			)),
			'irekiera_nora' => new sfWidgetFormData(array
			(
			)),
			'ixte_noiztik' => new sfWidgetFormData(array
			(
			)),
			'ixte_nora' => new sfWidgetFormData(array
			(
			)),
			'hasiera_aurreikusia_noiztik' => new sfWidgetFormData(array
			(
			)),
			'hasiera_aurreikusia_nora' => new sfWidgetFormData(array
			(
			)),
			'amaiera_aurreikusia_noiztik' => new sfWidgetFormData(array
			(
			)),
			'amaiera_aurreikusia_nora' => new sfWidgetFormData(array
			(
			)),
			'klasea' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Klasea',
				'add_empty' => '--',
				'query' => Doctrine_Core::getTable('Klasea')->createQuery('k')
					->leftJoin('k.Translation t WITH t.lang = ?', $culture)
					->orderBy('t.izena ASC')
			)),
			'arloa' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Arloa',
				'add_empty' => '--',
				'query' => Doctrine_Core::getTable('Arloa')->createQuery('a')
					->leftJoin('a.Translation t WITH t.lang = ?', $culture)
					->orderBy('t.izena ASC')
			)),
			'saila' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Saila',
				'add_empty' => '--',
				'query' => Doctrine_Core::getTable('Saila')->createQuery('s')
					->leftJoin('s.Translation t WITH t.lang = ?', $culture)
					->orderBy('t.name ASC')
			)),
			// el plugin sfDependentSelectPlugin requiere que los widgets tengan el como identificador <nombre_tabla>_id
			'mota_id' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Mota',
				'add_empty' => '--',
				'query' => Doctrine_Core::getTable('Mota')->createQuery('m')
					->leftJoin('m.Translation t WITH t.lang = ?', $culture)
					->orderBy('t.izena ASC')
			)),
			'azpimota_id' => new sfWidgetFormDoctrineDependentSelect(array
			(
				'model' => 'Azpimota',
				'depends' => 'Mota',
				'add_empty' => '--',
				'table_method' => 'getAzpimotaQuery',
				'order_by' => array('izena', 'ASC')
			)),
			'barrutia' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Barrutia',
				'add_empty' => '--',
				'query' => Doctrine_Core::getTable('Barrutia')->createQuery('b')
					->orderBy('b.izena ASC')
			)),
			'auzoa' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Auzoa',
				'add_empty' => '--',
				'query' => Doctrine_Core::getTable('Auzoa')->createQuery('a')
					->orderBy('a.izena ASC')
			)),
			'kalea' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Kalea',
				'add_empty' => '--',
				'query' => Doctrine_Core::getTable('Kalea')->createQuery('k')
					->orderBy('k.izena ASC')
			)),
			'eraikina' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Eraikina',
				'add_empty' => '--',
				'query' => Doctrine_Core::getTable('Eraikina')->createQuery('e')
					->orderBy('e.izena ASC')
			)),
			'egoera' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Egoera',
				'add_empty' => '--',
				'query' => Doctrine_Core::getTable('Egoera')->createQuery('e')
					->leftJoin('e.Translation t WITH t.lang = ?', $culture)
					->orderBy('e.id ASC')
			)),
		));

		$this->validatorSchema['sailkapena1'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['sailkapena2'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['sailkapena3'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['irekiera_noiztik'] = new sfValidatorDataOrdua(array('required' => false));
		$this->validatorSchema['irekiera_nora'] = new sfValidatorDataOrdua(array('required' => false));
		$this->validatorSchema['ixte_noiztik'] = new sfValidatorDataOrdua(array('required' => false));
		$this->validatorSchema['ixte_nora'] = new sfValidatorDataOrdua(array('required' => false));
		$this->validatorSchema['hasiera_aurreikusia_noiztik'] = new sfValidatorDataOrdua(array('required' => false));
		$this->validatorSchema['hasiera_aurreikusia_nora'] = new sfValidatorDataOrdua(array('required' => false));
		$this->validatorSchema['amaiera_aurreikusia_noiztik'] = new sfValidatorDataOrdua(array('required' => false));
		$this->validatorSchema['amaiera_aurreikusia_nora'] = new sfValidatorDataOrdua(array('required' => false));
		$this->validatorSchema['klasea'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['arloa'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['saila'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['mota_id'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['azpimota_id'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['barrutia'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['auzoa'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['kalea'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['eraikina'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['egoera'] = new sfValidatorString(array('required' => false));

		$this->widgetSchema->setNameFormat('zerrendatu[%s]');
	}
}

?>