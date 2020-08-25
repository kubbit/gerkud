<?php

/**
 * Kontaktua form base class.
 *
 * @method Kontaktua getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseKontaktuaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'izena'      => new sfWidgetFormInputText(),
      'abizenak'   => new sfWidgetFormInputText(),
      'nan'        => new sfWidgetFormInputText(),
      'posta'      => new sfWidgetFormInputText(),
      'telefonoa'  => new sfWidgetFormInputText(),
      'ohartarazi' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('KontaktuaOhartaraztea'), 'add_empty' => true)),
      'hizkuntza'  => new sfWidgetFormInputText(),
      'pasahitza'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'izena'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'abizenak'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'nan'        => new sfValidatorString(array('max_length' => 9, 'required' => false)),
      'posta'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'telefonoa'  => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'ohartarazi' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('KontaktuaOhartaraztea'), 'column' => 'id', 'required' => false)),
      'hizkuntza'  => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'pasahitza'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
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
