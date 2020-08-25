<?php

/**
 * BaseGeo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property int         $gertakaria_id                 Type: integer
 * @property double      $longitudea                    Type: double(18)
 * @property double      $latitudea                     Type: double(18)
 * @property double      $zehaztasuna                   Type: double(18)
 * @property string      $testua                        Type: string(50)
 * @property int         $geometria_id                  Type: integer
 * @property Gertakaria  $Gertakaria                    
 * @property Geometria   $Geometria                     
 *  
 * @method int           getGertakariaId()              Type: integer
 * @method double        getLongitudea()                Type: double(18)
 * @method double        getLatitudea()                 Type: double(18)
 * @method double        getZehaztasuna()               Type: double(18)
 * @method string        getTestua()                    Type: string(50)
 * @method int           getGeometriaId()               Type: integer
 * @method Gertakaria    getGertakaria()                
 * @method Geometria     getGeometria()                 
 *  
 * @method Geo           setGertakariaId(int $val)      Type: integer
 * @method Geo           setLongitudea(double $val)     Type: double(18)
 * @method Geo           setLatitudea(double $val)      Type: double(18)
 * @method Geo           setZehaztasuna(double $val)    Type: double(18)
 * @method Geo           setTestua(string $val)         Type: string(50)
 * @method Geo           setGeometriaId(int $val)       Type: integer
 * @method Geo           setGertakaria(Gertakaria $val) 
 * @method Geo           setGeometria(Geometria $val)   
 *  
 * @package    gerkud
 * @subpackage model
 * @author     Pasaiako Udala
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGeo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('geo');
        $this->hasColumn('gertakaria_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('longitudea', 'double', 18, array(
             'type' => 'double',
             'scale' => 6,
             'notnull' => true,
             'length' => 18,
             ));
        $this->hasColumn('latitudea', 'double', 18, array(
             'type' => 'double',
             'scale' => 6,
             'notnull' => true,
             'length' => 18,
             ));
        $this->hasColumn('zehaztasuna', 'double', 18, array(
             'type' => 'double',
             'scale' => 6,
             'notnull' => false,
             'length' => 18,
             ));
        $this->hasColumn('testua', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('geometria_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Gertakaria', array(
             'local' => 'gertakaria_id',
             'foreign' => 'id',
             'onDelete' => 'RESTRICT'));

        $this->hasOne('Geometria', array(
             'local' => 'geometria_id',
             'foreign' => 'id',
             'onDelete' => 'RESTRICT'));
    }
}