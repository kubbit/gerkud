<?php

/**
 * Saila form base class.
 *
 * @method Saila getObject() Returns the current form's model object
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id$
 */
abstract class BaseSailaForm extends sfGuardGroupForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('saila[%s]');
  }

  public function getModelName()
  {
    return 'Saila';
  }

}
