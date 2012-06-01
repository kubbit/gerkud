<?php

/**
 * Eraikina form base class.
 *
 * @method Eraikina getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEraikinaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'izena'       => new sfWidgetFormInputText(),
      'barrutia_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Barrutia'), 'add_empty' => false)),
      'longitudea'  => new sfWidgetFormInputText(),
      'latitudea'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'izena'       => new sfValidatorString(array('max_length' => 255)),
      'barrutia_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Barrutia'))),
      'longitudea'  => new sfValidatorPass(),
      'latitudea'   => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('eraikina[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Eraikina';
  }

}
