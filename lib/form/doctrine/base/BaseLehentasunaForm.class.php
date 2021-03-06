<?php

/**
 * Lehentasuna form base class.
 *
 * @method Lehentasuna getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseLehentasunaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'kolorea' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'kolorea' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lehentasuna[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Lehentasuna';
  }

}
