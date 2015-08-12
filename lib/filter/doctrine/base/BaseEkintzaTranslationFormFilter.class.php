<?php

/**
 * EkintzaTranslation filter form base class.
 *
 * @package    gerkud
 * @subpackage filter
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseEkintzaTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mota' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mota' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ekintza_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EkintzaTranslation';
  }

  public function getFields()
  {
    return array(
      'id'   => 'Number',
      'mota' => 'Text',
      'lang' => 'Text',
    );
  }
}
