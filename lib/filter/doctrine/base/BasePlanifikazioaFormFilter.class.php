<?php

/**
 * Planifikazioa filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePlanifikazioaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'gertakaria_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'add_empty' => true)),
      'langilea_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'add_empty' => true)),
      'hasiera_data'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'hasiera_ordua_noiztik'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'hasiera_ordua_noizarte' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'amaiera_data'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'amaiera_ordua_noiztik'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'amaiera_ordua_noizarte' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'gertakaria_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Gertakaria'), 'column' => 'id')),
      'langilea_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Langilea'), 'column' => 'id')),
      'hasiera_data'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'hasiera_ordua_noiztik'  => new sfValidatorPass(array('required' => false)),
      'hasiera_ordua_noizarte' => new sfValidatorPass(array('required' => false)),
      'amaiera_data'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'amaiera_ordua_noiztik'  => new sfValidatorPass(array('required' => false)),
      'amaiera_ordua_noizarte' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('planifikazioa_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Planifikazioa';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'gertakaria_id'          => 'ForeignKey',
      'langilea_id'            => 'ForeignKey',
      'hasiera_data'           => 'Date',
      'hasiera_ordua_noiztik'  => 'Text',
      'hasiera_ordua_noizarte' => 'Text',
      'amaiera_data'           => 'Date',
      'amaiera_ordua_noiztik'  => 'Text',
      'amaiera_ordua_noizarte' => 'Text',
    );
  }
}
