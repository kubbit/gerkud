<?php

/**
 * Fitxategia form base class.
 *
 * @method Fitxategia getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseFitxategiaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'gertakaria_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'add_empty' => false)),
      'langilea_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'add_empty' => true)),
      'fitxategia'    => new sfWidgetFormInputText(),
      'deskribapena'  => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'gertakaria_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'column' => 'id')),
      'langilea_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'column' => 'id', 'required' => false)),
      'fitxategia'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'deskribapena'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('fitxategia[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Fitxategia';
  }

}
