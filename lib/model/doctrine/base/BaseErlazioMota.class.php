<?php

/**
 * BaseErlazioMota
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string                           $izena                                 Type: string(255)
 * @property Doctrine_Collection|Erlazioak[]  $Erlazioak                             
 *  
 * @method string                             getIzena()                             Type: string(255)
 * @method Doctrine_Collection|Erlazioak[]    getErlazioak()                         
 *  
 * @method ErlazioMota                        setIzena(string $val)                  Type: string(255)
 * @method ErlazioMota                        setErlazioak(Doctrine_Collection $val) 
 *  
 * @package    gerkud
 * @subpackage model
 * @author     Pasaiako Udala
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseErlazioMota extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('erlazio_mota');
        $this->hasColumn('izena', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Erlazioak', array(
             'local' => 'id',
             'foreign' => 'erlazio_mota_id'));

        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'izena',
             ),
             ));
        $this->actAs($i18n0);
    }
}