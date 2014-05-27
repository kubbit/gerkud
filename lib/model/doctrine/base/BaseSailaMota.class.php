<?php

/**
 * BaseSailaMota
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $saila_id
 * @property integer $mota_id
 * @property Saila $Saila
 * @property Mota $Mota
 * 
 * @method integer   getSailaId()  Returns the current record's "saila_id" value
 * @method integer   getMotaId()   Returns the current record's "mota_id" value
 * @method Saila     getSaila()    Returns the current record's "Saila" value
 * @method Mota      getMota()     Returns the current record's "Mota" value
 * @method SailaMota setSailaId()  Sets the current record's "saila_id" value
 * @method SailaMota setMotaId()   Sets the current record's "mota_id" value
 * @method SailaMota setSaila()    Sets the current record's "Saila" value
 * @method SailaMota setMota()     Sets the current record's "Mota" value
 * 
 * @package    gerkud
 * @subpackage model
 * @author     Pasaiako Udala
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSailaMota extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('saila_mota');
        $this->hasColumn('saila_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('mota_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Saila', array(
             'local' => 'saila_id',
             'foreign' => 'id',
             'onDelete' => 'RESTRICT'));

        $this->hasOne('Mota', array(
             'local' => 'mota_id',
             'foreign' => 'id',
             'onDelete' => 'RESTRICT'));
    }
}