<?php

/**
 * Kalea form base class.
 *
 * @method Kalea getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseKaleaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'barrutia_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Barrutia'), 'add_empty' => true)),
      'auzoa_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Auzoa'), 'add_empty' => true)),
      'izena'       => new sfWidgetFormInputText(),
      'google'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'barrutia_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Barrutia'), 'column' => 'id', 'required' => false)),
      'auzoa_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Auzoa'), 'column' => 'id', 'required' => false)),
      'izena'       => new sfValidatorString(array('max_length' => 255)),
      'google'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Kalea', 'column' => array('izena')))
    );

    $this->widgetSchema->setNameFormat('kalea[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Kalea';
  }

}
