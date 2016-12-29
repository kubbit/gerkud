<?php

/**
 * Kontaktua filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseKontaktuaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'izena'      => new sfWidgetFormFilterInput(),
      'abizenak'   => new sfWidgetFormFilterInput(),
      'nan'        => new sfWidgetFormFilterInput(),
      'posta'      => new sfWidgetFormFilterInput(),
      'telefonoa'  => new sfWidgetFormFilterInput(),
      'ohartarazi' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('KontaktuaOhartaraztea'), 'add_empty' => true)),
      'hizkuntza'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'izena'      => new sfValidatorPass(array('required' => false)),
      'abizenak'   => new sfValidatorPass(array('required' => false)),
      'nan'        => new sfValidatorPass(array('required' => false)),
      'posta'      => new sfValidatorPass(array('required' => false)),
      'telefonoa'  => new sfValidatorPass(array('required' => false)),
      'ohartarazi' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('KontaktuaOhartaraztea'), 'column' => 'id')),
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
      'abizenak'   => 'Text',
      'nan'        => 'Text',
      'posta'      => 'Text',
      'telefonoa'  => 'Text',
      'ohartarazi' => 'ForeignKey',
      'hizkuntza'  => 'Text',
    );
  }
}
