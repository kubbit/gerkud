<?php

/**
 * Erlazioak filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseErlazioakFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'hasiera_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria_3'), 'add_empty' => true)),
      'amaiera_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'add_empty' => true)),
      'erlazio_mota_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ErlazioMota'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'hasiera_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Gertakaria_3'), 'column' => 'id')),
      'amaiera_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Gertakaria'), 'column' => 'id')),
      'erlazio_mota_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ErlazioMota'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('erlazioak_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Erlazioak';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'hasiera_id'      => 'ForeignKey',
      'amaiera_id'      => 'ForeignKey',
      'erlazio_mota_id' => 'ForeignKey',
    );
  }
}
