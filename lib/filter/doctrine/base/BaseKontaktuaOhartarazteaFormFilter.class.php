<?php

/**
 * KontaktuaOhartaraztea filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseKontaktuaOhartarazteaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ordena' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'ordena' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('kontaktua_ohartaraztea_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'KontaktuaOhartaraztea';
  }

  public function getFields()
  {
    return array(
      'id'     => 'Number',
      'ordena' => 'Number',
    );
  }
}
