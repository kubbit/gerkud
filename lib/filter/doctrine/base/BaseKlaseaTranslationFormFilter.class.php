<?php

/**
 * KlaseaTranslation filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseKlaseaTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'izena' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'izena' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('klasea_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'KlaseaTranslation';
  }

  public function getFields()
  {
    return array(
      'id'    => 'Number',
      'izena' => 'Text',
      'lang'  => 'Text',
    );
  }
}
