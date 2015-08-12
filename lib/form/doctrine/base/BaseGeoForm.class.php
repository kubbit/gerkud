<?php

/**
 * Geo form base class.
 *
 * @method Geo getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseGeoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'gertakaria_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'add_empty' => false)),
      'longitudea'    => new sfWidgetFormInputText(),
      'latitudea'     => new sfWidgetFormInputText(),
      'zehaztasuna'   => new sfWidgetFormInputText(),
      'testua'        => new sfWidgetFormInputText(),
      'geometria_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Geometria'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'gertakaria_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'column' => 'id')),
      'longitudea'    => new sfValidatorPass(),
      'latitudea'     => new sfValidatorPass(),
      'zehaztasuna'   => new sfValidatorPass(array('required' => false)),
      'testua'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'geometria_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Geometria'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('geo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Geo';
  }

}
