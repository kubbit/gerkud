<?php

/**
 * Kontaktua filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseKontaktuaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'izena'      => new sfWidgetFormFilterInput(),
      'posta'      => new sfWidgetFormFilterInput(),
      'telefonoa'  => new sfWidgetFormFilterInput(),
      'ohartarazi' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'hizkuntza'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'izena'      => new sfValidatorPass(array('required' => false)),
      'posta'      => new sfValidatorPass(array('required' => false)),
      'telefonoa'  => new sfValidatorPass(array('required' => false)),
      'ohartarazi' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'hizkuntza'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('kontaktua_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Kontaktua';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'izena'      => 'Text',
      'posta'      => 'Text',
      'telefonoa'  => 'Text',
      'ohartarazi' => 'Boolean',
      'hizkuntza'  => 'Text',
    );
  }
}
