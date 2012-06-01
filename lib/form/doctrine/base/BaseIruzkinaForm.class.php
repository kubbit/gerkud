<?php

/**
 * Iruzkina form base class.
 *
 * @method Iruzkina getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIruzkinaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'gertakaria_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'add_empty' => false)),
      'langilea_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'add_empty' => true)),
      'ekintza_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ekintza'), 'add_empty' => true)),
      'testua'        => new sfWidgetFormTextarea(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'gertakaria_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'))),
      'langilea_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'required' => false)),
      'ekintza_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ekintza'), 'required' => false)),
      'testua'        => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('iruzkina[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Iruzkina';
  }

}
