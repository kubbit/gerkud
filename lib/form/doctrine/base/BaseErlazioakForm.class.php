<?php

/**
 * Erlazioak form base class.
 *
 * @method Erlazioak getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseErlazioakForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'hasiera_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria_3'), 'add_empty' => false)),
      'amaiera_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'add_empty' => false)),
      'erlazio_mota_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ErlazioMota'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'hasiera_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria_3'))),
      'amaiera_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'))),
      'erlazio_mota_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ErlazioMota'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('erlazioak[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Erlazioak';
  }

}
