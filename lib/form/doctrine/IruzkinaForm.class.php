<?php

/**
 * Iruzkina form.
 *
 * @package    gerkud
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class IruzkinaForm extends BaseIruzkinaForm
{
	public function configure()
	{
		$culture = sfContext::getInstance()->getUser()->getCulture();

		$this->widgetSchema['gertakaria_id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['langilea_id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['ekintza_id'] = new sfWidgetFormInputHidden();

		$this->widgetSchema['saila_id'] = new sfWidgetFormDoctrineChoice(array
		(
			'model' => 'Saila',
			'add_empty' => '--',
			'query' => Doctrine_Core::getTable('Saila')->createQuery('s')
				->select('s.id, t.name')
				->leftJoin('s.Translation t WITH t.lang = ?', $culture)
				->orderBy('t.name ASC')
		));

		$this->validatorSchema['saila_id'] = new sfValidatorString(array
		(
			'required' => false
		));

		unset
		(
			$this['created_at'], $this['updated_at']
		);

		$this->widgetSchema['gertakaria_id'] = new sfWidgetFormTextarea();

		$this->validatorSchema->setPostValidator
		(
			new sfValidatorCallback(array('callback' => array($this, 'postValidate')))
		);
	}

	public function updateTestuaColumn($value)
	{
		return $value;
	}

	public function postValidate($validator, $values)
	{
		if ($values['ekintza_id'] == 1 AND empty($values['testua']))
		{
			$error = new sfValidatorError($validator, 'Required.');
			throw new sfValidatorErrorSchema($validator, array('testua' => $error));
		}

		if ($values['ekintza_id'] == 2 AND empty($values['saila_id']))
		{
			$error = new sfValidatorError($validator, 'Required.');
			throw new sfValidatorErrorSchema($validator, array('testua' => $error));
		}

		return $values;
	}
}
