<?php

/**
 * Geo filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGeoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'gertakaria_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Gertakaria'), 'add_empty' => true)),
      'longitudea'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'latitudea'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'testua'        => new sfWidgetFormFilterInput(),
      'geometria_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Geometria'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'gertakaria_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Gertakaria'), 'column' => 'id')),
      'longitudea'    => new sfValidatorPass(array('required' => false)),
      'latitudea'     => new sfValidatorPass(array('required' => false)),
      'testua'        => new sfValidatorPass(array('required' => false)),
      'geometria_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Geometria'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('geo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Geo';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'gertakaria_id' => 'ForeignKey',
      'longitudea'    => 'Text',
      'latitudea'     => 'Text',
      'testua'        => 'Text',
      'geometria_id'  => 'ForeignKey',
    );
  }
}
