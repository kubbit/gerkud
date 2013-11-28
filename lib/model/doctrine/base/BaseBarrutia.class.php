<?php

/**
 * BaseBarrutia
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $izena
 * @property Doctrine_Collection $Gertakaria
 * @property Doctrine_Collection $Auzoa
 * @property Doctrine_Collection $Kalea
 * @property Doctrine_Collection $Eraikina
 * 
 * @method string              getIzena()      Returns the current record's "izena" value
 * @method Doctrine_Collection getGertakaria() Returns the current record's "Gertakaria" collection
 * @method Doctrine_Collection getAuzoa()      Returns the current record's "Auzoa" collection
 * @method Doctrine_Collection getKalea()      Returns the current record's "Kalea" collection
 * @method Doctrine_Collection getEraikina()   Returns the current record's "Eraikina" collection
 * @method Barrutia            setIzena()      Sets the current record's "izena" value
 * @method Barrutia            setGertakaria() Sets the current record's "Gertakaria" collection
 * @method Barrutia            setAuzoa()      Sets the current record's "Auzoa" collection
 * @method Barrutia            setKalea()      Sets the current record's "Kalea" collection
 * @method Barrutia            setEraikina()   Sets the current record's "Eraikina" collection
 * 
 * @package    gerkud
 * @subpackage model
 * @author     Pasaiako Udala
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBarrutia extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('barrutia');
        $this->hasColumn('izena', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Gertakaria', array(
             'local' => 'id',
             'foreign' => 'barrutia_id'));

        $this->hasMany('Auzoa', array(
             'local' => 'id',
             'foreign' => 'barrutia_id'));

        $this->hasMany('Kalea', array(
             'local' => 'id',
             'foreign' => 'barrutia_id'));

        $this->hasMany('Eraikina', array(
             'local' => 'id',
             'foreign' => 'barrutia_id'));
    }
}