<?php

/**
 * SailekoLangileak filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSailekoLangileakFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'saila_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Saila'), 'add_empty' => true)),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Langilea'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'saila_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Saila'), 'column' => 'id')),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Langilea'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('saileko_langileak_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SailekoLangileak';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'saila_id'         => 'ForeignKey',
      'sf_guard_user_id' => 'ForeignKey',
    );
  }
}
