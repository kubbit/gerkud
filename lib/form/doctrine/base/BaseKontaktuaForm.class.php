<?php

/**
 * Kontaktua form base class.
 *
 * @method Kontaktua getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseKontaktuaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'izena'      => new sfWidgetFormInputText(),
      'posta'      => new sfWidgetFormInputText(),
      'telefonoa'  => new sfWidgetFormInputText(),
      'ohartarazi' => new sfWidgetFormInputCheckbox(),
      'hizkuntza'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'izena'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'posta'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'telefonoa'  => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'ohartarazi' => new sfValidatorBoolean(array('required' => false)),
      'hizkuntza'  => new sfValidatorString(array('max_length' => 2, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('kontaktua[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Kontaktua';
  }

}
