<?php

/**
 * Egoera filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseEgoeraFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'kolorea' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'kolorea' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('egoera_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Egoera';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'kolorea' => 'Text',
    );
  }
}
