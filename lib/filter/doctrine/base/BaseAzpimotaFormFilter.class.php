<?php

/**
 * Azpimota filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseAzpimotaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mota_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mota'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'mota_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Mota'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('azpimota_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Azpimota';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'mota_id' => 'ForeignKey',
    );
  }
}
