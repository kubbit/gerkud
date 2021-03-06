<?php

/**
 * Eraikina filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseEraikinaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'izena'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'barrutia_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Barrutia'), 'add_empty' => true)),
      'auzoa_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Auzoa'), 'add_empty' => true)),
      'longitudea'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'latitudea'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'izena'       => new sfValidatorPass(array('required' => false)),
      'barrutia_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Barrutia'), 'column' => 'id')),
      'auzoa_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Auzoa'), 'column' => 'id')),
      'longitudea'  => new sfValidatorPass(array('required' => false)),
      'latitudea'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('eraikina_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Eraikina';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'izena'       => 'Text',
      'barrutia_id' => 'ForeignKey',
      'auzoa_id'    => 'ForeignKey',
      'longitudea'  => 'Text',
      'latitudea'   => 'Text',
    );
  }
}
