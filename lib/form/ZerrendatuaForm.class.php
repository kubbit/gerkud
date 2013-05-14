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
	public static $sailkapena = array(-1 => '--', 1 => 'Saila', 2 => 'Auzoa', 3 => 'Mota');

	public function configure()
	{
		$culture = sfContext::getInstance()->getUser()->getCulture();

		$this->setWidgets(array
		(
			'sailkapena' => new sfWidgetFormSelect(array
			(
				'choices' => self::$sailkapena
			)),
			'hasiera' => new sfWidgetFormI18nDate(array
			(
				'culture' => $culture
			)),
			'amaiera' => new sfWidgetFormI18nDate(array
			(
				'culture' => $culture
			)),
			'klasea' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Klasea',
				'add_empty' => '--',
				'query' => Doctrine::getTable('Klasea')->createQuery('k')
					->leftJoin('k.Translation t WITH t.lang = ?', $culture)
					->orderBy('t.izena ASC')
			)),
			'saila' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Saila',
				'add_empty' => '--',
				'query' => Doctrine::getTable('Saila')->createQuery('s')
					->leftJoin('s.Translation t WITH t.lang = ?', $culture)
					->orderBy('t.name ASC')
			)),
			// el plugin sfDependentSelectPlugin requiere que los widgets tengan el como identificador <nombre_tabla>_id
			'mota_id' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Mota',
				'add_empty' => '--',
				'query' => Doctrine::getTable('Mota')->createQuery('m')
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
				'query' => Doctrine::getTable('Barrutia')->createQuery('b')
					->orderBy('b.izena ASC')
			)),
			'kalea' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Kalea',
				'add_empty' => '--',
				'query' => Doctrine::getTable('Kalea')->createQuery('k')
					->orderBy('k.izena ASC')
			)),
			'eraikina' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Eraikina',
				'add_empty' => '--',
				'query' => Doctrine::getTable('Eraikina')->createQuery('e')
					->orderBy('e.izena ASC')
			)),
			'egoera' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Egoera',
				'add_empty' => '--',
				'query' => Doctrine::getTable('Egoera')->createQuery('e')
					->leftJoin('e.Translation t WITH t.lang = ?', $culture)
					->orderBy('e.id ASC')
			)),
		));

		$this->widgetSchema->setNameFormat('zerrendatu[%s]');
	}
}

?>