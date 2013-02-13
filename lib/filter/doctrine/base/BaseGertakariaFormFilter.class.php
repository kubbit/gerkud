<?php

/**
 * Gertakaria filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGertakariaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'laburpena'           => new sfWidgetFormFilterInput(),
      'klasea_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Klasea'), 'add_empty' => true)),
      'mota_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mota'), 'add_empty' => true)),
      'azpimota_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Azpimota'), 'add_empty' => true)),
      'abisuaNork'          => new sfWidgetFormFilterInput(),
      'egoera_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Egoera'), 'add_empty' => true)),
      'saila_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Saila'), 'add_empty' => true)),
      'langilea_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'add_empty' => true)),
      'barrutia_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Barrutia'), 'add_empty' => true)),
      'kalea_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Kalea'), 'add_empty' => true)),
      'kale_zbkia'          => new sfWidgetFormFilterInput(),
      'deskribapena'        => new sfWidgetFormFilterInput(),
      'ixte_data'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'hasiera_aurreikusia' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'amaiera_aurreikusia' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'lehentasuna_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lehentasuna'), 'add_empty' => true)),
      'jatorrizkoSaila_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('JatorrizkoSaila'), 'add_empty' => true)),
      'eraikina_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Eraikina'), 'add_empty' => true)),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'laburpena'           => new sfValidatorPass(array('required' => false)),
      'klasea_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Klasea'), 'column' => 'id')),
      'mota_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Mota'), 'column' => 'id')),
      'azpimota_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Azpimota'), 'column' => 'id')),
      'abisuaNork'          => new sfValidatorPass(array('required' => false)),
      'egoera_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Egoera'), 'column' => 'id')),
      'saila_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Saila'), 'column' => 'id')),
      'langilea_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Langilea'), 'column' => 'id')),
      'barrutia_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Barrutia'), 'column' => 'id')),
      'kalea_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Kalea'), 'column' => 'id')),
      'kale_zbkia'          => new sfValidatorPass(array('required' => false)),
      'deskribapena'        => new sfValidatorPass(array('required' => false)),
      'ixte_data'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'hasiera_aurreikusia' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'amaiera_aurreikusia' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'lehentasuna_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Lehentasuna'), 'column' => 'id')),
      'jatorrizkoSaila_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('JatorrizkoSaila'), 'column' => 'id')),
      'eraikina_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Eraikina'), 'column' => 'id')),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('gertakaria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Gertakaria';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'laburpena'           => 'Text',
      'klasea_id'           => 'ForeignKey',
      'mota_id'             => 'ForeignKey',
      'azpimota_id'         => 'ForeignKey',
      'abisuaNork'          => 'Text',
      'egoera_id'           => 'ForeignKey',
      'saila_id'            => 'ForeignKey',
      'langilea_id'         => 'ForeignKey',
      'barrutia_id'         => 'ForeignKey',
      'kalea_id'            => 'ForeignKey',
      'kale_zbkia'          => 'Text',
      'deskribapena'        => 'Text',
      'ixte_data'           => 'Date',
      'hasiera_aurreikusia' => 'Date',
      'amaiera_aurreikusia' => 'Date',
      'lehentasuna_id'      => 'ForeignKey',
      'jatorrizkoSaila_id'  => 'ForeignKey',
      'eraikina_id'         => 'ForeignKey',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}
