<?php

/**
 * KontaktuaOhartarazteaTranslation filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseKontaktuaOhartarazteaTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'modua' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'modua' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('kontaktua_ohartaraztea_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'KontaktuaOhartarazteaTranslation';
  }

  public function getFields()
  {
    return array(
      'id'    => 'Number',
      'modua' => 'Text',
      'lang'  => 'Text',
    );
  }
}
