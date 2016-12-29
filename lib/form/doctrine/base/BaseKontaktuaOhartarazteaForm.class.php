<?php

/**
 * KontaktuaOhartaraztea form base class.
 *
 * @method KontaktuaOhartaraztea getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseKontaktuaOhartarazteaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'     => new sfWidgetFormInputHidden(),
      'ordena' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ordena' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('kontaktua_ohartaraztea[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'KontaktuaOhartaraztea';
  }

}
