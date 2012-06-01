<?php

/**
 * SailekoLangileak form base class.
 *
 * @method SailekoLangileak getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSailekoLangileakForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'saila_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Saila'), 'add_empty' => false)),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'saila_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Saila'))),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'))),
    ));

    $this->widgetSchema->setNameFormat('saileko_langileak[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SailekoLangileak';
  }

}
