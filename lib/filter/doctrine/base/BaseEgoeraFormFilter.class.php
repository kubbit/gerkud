<?php

/**
 * Egoera filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEgoeraFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'izena'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'kolorea' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'izena'   => new sfValidatorPass(array('required' => false)),
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
      'izena'   => 'Text',
      'kolorea' => 'Text',
    );
  }
}
