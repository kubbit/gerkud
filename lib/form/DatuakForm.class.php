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
	protected static $taulak = array(1 => 'Dataren arabera', 2 => 'Sailaren arabera', 3 => 'Egun desbiderapenaren arabera', 4 => 'Jatorrizko sailaren arabera');
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
			'hasiera' => new sfWidgetFormData(array
			(
			)),
			'amaiera' => new sfWidgetFormData(array
			(
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
				'query' => Doctrine_Core::getTable('Saila')->createQuery('s')
					->leftJoin('s.Translation t WITH t.lang = ?', $culture)
					->orderBy('t.name ASC')
			)),
			'jatorrizkosaila' => new sfWidgetFormDoctrineChoice(array
			(
				'model' => 'JatorrizkoSaila',
				'add_empty' => '--',
				'query' => Doctrine_Core::getTable('JatorrizkoSaila')->createQuery('s')
					->leftJoin('s.Translation t WITH t.lang = ?', $culture)
					->orderBy('t.izena ASC')
			))
		));
		$this->validatorSchema['taula'] = new sfValidatorString(array('required' => true));
		$this->validatorSchema['hasiera'] = new sfValidatorDataOrdua(array('required' => false));
		$this->validatorSchema['amaiera'] = new sfValidatorDataOrdua(array('required' => false));
		$this->validatorSchema['tartea'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['saila'] = new sfValidatorString(array('required' => false));
		$this->validatorSchema['jatorrizkosaila'] = new sfValidatorString(array('required' => false));

		$this->widgetSchema->setNameFormat('datuak[%s]');
	}
}

?>