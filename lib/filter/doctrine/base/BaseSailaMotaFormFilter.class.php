<?php

/**
 * SailaMota filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseSailaMotaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'saila_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Saila'), 'add_empty' => true)),
      'mota_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mota'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'saila_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Saila'), 'column' => 'id')),
      'mota_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Mota'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('saila_mota_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SailaMota';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'saila_id' => 'ForeignKey',
      'mota_id'  => 'ForeignKey',
    );
  }
}
