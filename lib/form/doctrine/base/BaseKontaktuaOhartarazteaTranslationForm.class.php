<?php

/**
 * KontaktuaOhartarazteaTranslation form base class.
 *
 * @method KontaktuaOhartarazteaTranslation getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseKontaktuaOhartarazteaTranslationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'    => new sfWidgetFormInputHidden(),
      'modua' => new sfWidgetFormInputText(),
      'lang'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'modua' => new sfValidatorString(array('max_length' => 100)),
      'lang'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('lang')), 'empty_value' => $this->getObject()->get('lang'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('kontaktua_ohartaraztea_translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'KontaktuaOhartarazteaTranslation';
  }

}
