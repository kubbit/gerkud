<?php

/**
 * Azpimota filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAzpimotaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mota_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mota'), 'add_empty' => true)),
      'izena'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'mota_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Mota'), 'column' => 'id')),
      'izena'   => new sfValidatorPass(array('required' => false)),
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
      'izena'   => 'Text',
    );
  }
}
