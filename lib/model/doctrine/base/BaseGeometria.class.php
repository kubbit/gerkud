<?php

/**
 * BaseGeometria
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string                     $mota                            Type: string(50)
 * @property Doctrine_Collection|Geo[]  $Geo                             
 *  
 * @method string                       getMota()                        Type: string(50)
 * @method Doctrine_Collection|Geo[]    getGeo()                         
 *  
 * @method Geometria                    setMota(string $val)             Type: string(50)
 * @method Geometria                    setGeo(Doctrine_Collection $val) 
 *  
 * @package    gerkud
 * @subpackage model
 * @author     Pasaiako Udala
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGeometria extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('geometria');
        $this->hasColumn('mota', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Geo', array(
             'local' => 'id',
             'foreign' => 'geometria_id'));
    }
}