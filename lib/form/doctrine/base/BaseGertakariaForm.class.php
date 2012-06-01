<?php

/**
 * Gertakaria form base class.
 *
 * @method Gertakaria getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGertakariaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'laburpena'          => new sfWidgetFormInputText(),
      'klasea_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Klasea'), 'add_empty' => true)),
      'mota_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mota'), 'add_empty' => false)),
      'azpimota_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Azpimota'), 'add_empty' => false)),
      'abisuaNork'         => new sfWidgetFormTextarea(),
      'harremanetarako'    => new sfWidgetFormTextarea(),
      'egoera_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Egoera'), 'add_empty' => false)),
      'saila_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Saila'), 'add_empty' => true)),
      'langilea_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'add_empty' => true)),
      'barrutia_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Barrutia'), 'add_empty' => true)),
      'kalea_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Kalea'), 'add_empty' => true)),
      'kale_zbkia'         => new sfWidgetFormInputText(),
      'deskribapena'       => new sfWidgetFormTextarea(),
      'ixte_data'          => new sfWidgetFormInputText(),
      'lehentasuna_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lehentasuna'), 'add_empty' => false)),
      'jatorrizkoSaila_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('JatorrizkoSaila'), 'add_empty' => true)),
      'eraikina_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Eraikina'), 'add_empty' => true)),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'laburpena'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'klasea_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Klasea'), 'required' => false)),
      'mota_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Mota'))),
      'azpimota_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Azpimota'))),
      'abisuaNork'         => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'harremanetarako'    => new sfValidatorString(array('max_length' => 1024, 'required' => false)),
      'egoera_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Egoera'), 'required' => false)),
      'saila_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Saila'), 'required' => false)),
      'langilea_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'required' => false)),
      'barrutia_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Barrutia'), 'required' => false)),
      'kalea_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Kalea'), 'required' => false)),
      'kale_zbkia'         => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'deskribapena'       => new sfValidatorString(array('max_length' => 4000, 'required' => false)),
      'ixte_data'          => new sfValidatorPass(array('required' => false)),
      'lehentasuna_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Lehentasuna'), 'required' => false)),
      'jatorrizkoSaila_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('JatorrizkoSaila'), 'required' => false)),
      'eraikina_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Eraikina'), 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('gertakaria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Gertakaria';
  }

}
