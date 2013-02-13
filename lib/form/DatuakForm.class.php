<?php

/**
 * Datu Estatistikoak
 *
 * @package    gerkud
 * @subpackage form
 * @author     Kubbit Information Technology
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class DatuakForm extends sfForm
{
	protected static $taulak = array(1 => 'Dataren arabera', 2 => 'Sailaren arabera', 3 => 'Egun desbiderapenaren arabera');
	protected static $tarteak = array(1 => 'Urteak', 2 => 'Hilabeteak', 4 => 'Asteak', 3 => 'Egunak');

	public function configure()
	{
		$culture = sfContext::getInstance()->getUser()->getCulture();

		$this->setWidgets(array
		(
			'taula' => new sfWidgetFormSelect(array
			(
				'choices' => self::$taulak
			)),
			'hasiera' => new sfWidgetFormI18nDate(array
			(
				'culture' => $culture
			)),
			'amaiera' => new sfWidgetFormI18nDate(array
			(
				'culture' => $culture
			)),
			'tartea' => new sfWidgetFormSelect(array
			(
				'choices' => self::$tarteak,
				'default' => 2
			)),
			'saila' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'Saila',
				'add_empty' => '--',
				'query' => Doctrine::getTable('Saila')->createQuery('s')
					->leftJoin('s.Translation t WITH t.lang = ?', $culture)
					->orderBy('t.name ASC')
			))
		));

		$this->widgetSchema->setNameFormat('datuak[%s]');
	}
}

?>