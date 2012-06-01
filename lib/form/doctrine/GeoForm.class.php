<?php

/**
 * Geo form.
 *
 * @package    gerkud
 * @subpackage form
 * @author     Pasaiako Udala
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GeoForm extends BaseGeoForm
{
  public function configure()
  {


        $this->widgetSchema['gertakaria_id'] = new sfWidgetFormTextarea();
  }
}
