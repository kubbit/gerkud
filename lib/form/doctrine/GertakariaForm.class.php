<?php

/**
 * Gertakaria form.
 *
 * @package    gerkud
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GertakariaForm extends BaseGertakariaForm
{
  public function configure()
  {


        $this->widgetSchema['barrutia_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Barrutia',
                'add_empty' => 'Aukeratu barrutia',
                ));
/*default context does not exist arazoa gertatzen denerako komentatu */
        $this->widgetSchema['kalea_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                    'model'     => 'Kalea',
                    'depends'   => 'Barrutia',
                    'add_empty' => 'Aukeratu kalea',
		    'order_by' => array('izena','asc')
                ));
/* */
        $this->widgetSchema['klasea_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Klasea',
                'add_empty' => 'Aukeratu klasea',
                ));
/* */
        $this->widgetSchema['mota_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Mota',
                'add_empty' => 'Aukeratu mota',
                'order_by' => array('izena','asc')
                ));

        $this->widgetSchema['laburpena'] = new sfWidgetFormTextarea(array(
                ));

        $this->widgetSchema['deskribapena'] = new sfWidgetFormTextarea(array(
                ));

	$this->validatorSchema['deskribapena'] = new sfValidatorString(array('required' => true));


/*default context does not exist arazoa gertatzen denerako komentatu */
        $this->widgetSchema['azpimota_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                    'model'     => 'Azpimota',
                    'depends'   => 'Mota',
                    'add_empty' => 'Aukeratu azpi-mota',
//                    'order_by' => array('izena','asc')
                ));
/* */


        $this->widgetSchema['eraikina_id'] = new sfWidgetFormDoctrineDependentSelect(array(
                    'model'     => 'Eraikina',
                    'depends'   => 'Barrutia',
                    'add_empty' => 'Aukeratu eraikina',
                ));



/*
        $this->widgetSchema['saila_id'] = new sfWidgetFormDoctrineChoice(array(
                  'model'     => 'Saila',
//                'model'     => ' sf_Guard_Group',
                  'add_empty' => 'Aukeratu saila',
		  'order_by' => array('name','asc')
                ));

        $this->widgetSchema['langilea_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Langilea',
                'add_empty' => 'Aukeratu Langilea',
                ));
*/

/*
        $this->widgetSchema['langilea'] = new sfWidgetFormDoctrineDependentSelect(array(
                'model'     => 'Langilea',
                'depends'   => 'Saila',
                'add_empty' => 'Aukeratu langilea',
                ));
*/


        $this->widgetSchema['klasea_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Klasea',
                'add_empty' => 'Aukeratu klasea',
                'order_by' => array('izena','asc')
                ));
/*
        $this->widgetSchema['eraikina_id'] = new sfWidgetFormDoctrineChoice(array(
                'model'     => 'Eraikina',
                'add_empty' => 'Aukeratu eraikina',
                'order_by' => array('izena','asc')
                ));
*/


/*default context does not exist arazoa gertatzen denerako komentatu */
     $urteak = range(2000, date ("Y"));
     if (sfContext::getInstance()->getConfiguration()->getApplication()=='es')
     {
        $this->widgetSchema['ixte_data'] = new sfWidgetFormI18nDate(array(
                'culture' =>'es',
                'format' => '%year%/%month%/%day%',
                'years' => array_combine($urteak, $urteak),
                'label' => 'Ixte data',
        ));

     } else
     {
        $this->widgetSchema['ixte_data'] = new sfWidgetFormI18nDate(array(
                'culture' =>'eu',
                'format' => '%year%/%month%/%day%',
                'years' => array_combine($urteak, $urteak),
                'label' => 'Ixte data',
        ));
     }
        unset(
              $this['created_at'], $this['updated_at']
        );
/* */
  }

}
