<?php

/**
 * Planifikazioa form base class.
 *
 * @method Planifikazioa getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BasePlanifikazioaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'gertakaria_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'add_empty' => false)),
      'langilea_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'add_empty' => false)),
      'hasiera_data'           => new sfWidgetFormDate(),
      'hasiera_ordua_noiztik'  => new sfWidgetFormTime(),
      'hasiera_ordua_noizarte' => new sfWidgetFormTime(),
      'amaiera_data'           => new sfWidgetFormDate(),
      'amaiera_ordua_noiztik'  => new sfWidgetFormTime(),
      'amaiera_ordua_noizarte' => new sfWidgetFormTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'gertakaria_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'column' => 'id')),
      'langilea_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'column' => 'id')),
      'hasiera_data'           => new sfValidatorDate(),
      'hasiera_ordua_noiztik'  => new sfValidatorTime(),
      'hasiera_ordua_noizarte' => new sfValidatorTime(),
      'amaiera_data'           => new sfValidatorDate(),
      'amaiera_ordua_noiztik'  => new sfValidatorTime(),
      'amaiera_ordua_noizarte' => new sfValidatorTime(),
    ));

    $this->widgetSchema->setNameFormat('planifikazioa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Planifikazioa';
  }

}
