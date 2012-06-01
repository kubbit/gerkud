<?php

/**
 * Geometria filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGeometriaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mota' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mota' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('geometria_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Geometria';
  }

  public function getFields()
  {
    return array(
      'id'   => 'Number',
      'mota' => 'Text',
    );
  }
}
