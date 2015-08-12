<?php

/**
 * Lehentasuna filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseLehentasunaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'kolorea' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'kolorea' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lehentasuna_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Lehentasuna';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'kolorea' => 'Text',
    );
  }
}
