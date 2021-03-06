<?php

/**
 * BaseErlazioak
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property int          $hasiera_id                      Type: integer
 * @property int          $amaiera_id                      Type: integer
 * @property int          $erlazio_mota_id                 Type: integer
 * @property ErlazioMota  $ErlazioMota                     
 * @property Gertakaria   $Gertakaria                      
 * @property Gertakaria   $Gertakaria_3                    
 *  
 * @method int            getHasieraId()                   Type: integer
 * @method int            getAmaieraId()                   Type: integer
 * @method int            getErlazioMotaId()               Type: integer
 * @method ErlazioMota    getErlazioMota()                 
 * @method Gertakaria     getGertakaria()                  
 * @method Gertakaria     getGertakaria_3()                
 *  
 * @method Erlazioak      setHasieraId(int $val)           Type: integer
 * @method Erlazioak      setAmaieraId(int $val)           Type: integer
 * @method Erlazioak      setErlazioMotaId(int $val)       Type: integer
 * @method Erlazioak      setErlazioMota(ErlazioMota $val) 
 * @method Erlazioak      setGertakaria(Gertakaria $val)   
 * @method Erlazioak      setGertakaria_3(Gertakaria $val) 
 *  
 * @package    gerkud
 * @subpackage model
 * @author     Pasaiako Udala
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseErlazioak extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('erlazioak');
        $this->hasColumn('hasiera_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('amaiera_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('erlazio_mota_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ErlazioMota', array(
             'local' => 'erlazio_mota_id',
             'foreign' => 'id',
             'onDelete' => 'RESTRICT'));

        $this->hasOne('Gertakaria', array(
             'local' => 'amaiera_id',
             'foreign' => 'id',
             'onDelete' => 'RESTRICT'));

        $this->hasOne('Gertakaria as Gertakaria_3', array(
             'local' => 'hasiera_id',
             'foreign' => 'id',
             'onDelete' => 'RESTRICT'));
    }
}