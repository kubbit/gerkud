<?php

/**
 * EgunTarteak form base class.
 *
 * @method EgunTarteak getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEgunTarteakForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'minimoa' => new sfWidgetFormInputText(),
      'maximoa' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'minimoa' => new sfValidatorInteger(),
      'maximoa' => new sfValidatorInteger(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'EgunTarteak', 'column' => array('minimoa'))),
        new sfValidatorDoctrineUnique(array('model' => 'EgunTarteak', 'column' => array('maximoa'))),
      ))
    );

    $this->widgetSchema->setNameFormat('egun_tarteak[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EgunTarteak';
  }

}
