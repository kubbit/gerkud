<?php

/**
 * Ohartaraztea filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseOhartarazteaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mota' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'mota' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ohartaraztea_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ohartaraztea';
  }

  public function getFields()
  {
    return array(
      'id'   => 'Number',
      'mota' => 'Text',
    );
  }
}
