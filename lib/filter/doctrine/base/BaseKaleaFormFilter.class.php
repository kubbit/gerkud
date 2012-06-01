<?php

/**
 * Kalea filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseKaleaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'barrutia_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Barrutia'), 'add_empty' => true)),
      'izena'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'google'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'barrutia_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Barrutia'), 'column' => 'id')),
      'izena'       => new sfValidatorPass(array('required' => false)),
      'google'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('kalea_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Kalea';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'barrutia_id' => 'ForeignKey',
      'izena'       => 'Text',
      'google'      => 'Text',
    );
  }
}
