<?php

/**
 * EgunTarteak filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEgunTarteakFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'minimoa' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'maximoa' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'minimoa' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'maximoa' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('egun_tarteak_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EgunTarteak';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'minimoa' => 'Number',
      'maximoa' => 'Number',
    );
  }
}
