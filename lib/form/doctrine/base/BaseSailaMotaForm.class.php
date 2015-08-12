<?php

/**
 * SailaMota form base class.
 *
 * @method SailaMota getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseSailaMotaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'saila_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Saila'), 'add_empty' => false)),
      'mota_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mota'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'saila_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Saila'), 'column' => 'id')),
      'mota_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Mota'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('saila_mota[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SailaMota';
  }

}
