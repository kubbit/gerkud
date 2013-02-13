<?php

/**
 * BaseGertakaria
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $laburpena
 * @property integer $klasea_id
 * @property integer $mota_id
 * @property integer $azpimota_id
 * @property string $abisuaNork
 * @property integer $egoera_id
 * @property integer $saila_id
 * @property integer $langilea_id
 * @property integer $barrutia_id
 * @property integer $kalea_id
 * @property string $kale_zbkia
 * @property string $deskribapena
 * @property datetime $ixte_data
 * @property date $hasiera_aurreikusia
 * @property date $amaiera_aurreikusia
 * @property integer $lehentasuna_id
 * @property integer $jatorrizkoSaila_id
 * @property integer $eraikina_id
 * @property Klasea $Klasea
 * @property Mota $Mota
 * @property Azpimota $Azpimota
 * @property Barrutia $Barrutia
 * @property Kalea $Kalea
 * @property Saila $Saila
 * @property Langilea $Langilea
 * @property Egoera $Egoera
 * @property Lehentasuna $Lehentasuna
 * @property JatorrizkoSaila $JatorrizkoSaila
 * @property Eraikina $Eraikina
 * @property Doctrine_Collection $Fitxategia
 * @property Doctrine_Collection $Iruzkina
 * @property Doctrine_Collection $Planifikazioa
 * @property Doctrine_Collection $Geo
 * 
 * @method string              getLaburpena()           Returns the current record's "laburpena" value
 * @method integer             getKlaseaId()            Returns the current record's "klasea_id" value
 * @method integer             getMotaId()              Returns the current record's "mota_id" value
 * @method integer             getAzpimotaId()          Returns the current record's "azpimota_id" value
 * @method string              getAbisuaNork()          Returns the current record's "abisuaNork" value
 * @method integer             getEgoeraId()            Returns the current record's "egoera_id" value
 * @method integer             getSailaId()             Returns the current record's "saila_id" value
 * @method integer             getLangileaId()          Returns the current record's "langilea_id" value
 * @method integer             getBarrutiaId()          Returns the current record's "barrutia_id" value
 * @method integer             getKaleaId()             Returns the current record's "kalea_id" value
 * @method string              getKaleZbkia()           Returns the current record's "kale_zbkia" value
 * @method string              getDeskribapena()        Returns the current record's "deskribapena" value
 * @method datetime            getIxteData()            Returns the current record's "ixte_data" value
 * @method date                getHasieraAurreikusia()  Returns the current record's "hasiera_aurreikusia" value
 * @method date                getAmaieraAurreikusia()  Returns the current record's "amaiera_aurreikusia" value
 * @method integer             getLehentasunaId()       Returns the current record's "lehentasuna_id" value
 * @method integer             getJatorrizkoSailaId()   Returns the current record's "jatorrizkoSaila_id" value
 * @method integer             getEraikinaId()          Returns the current record's "eraikina_id" value
 * @method Klasea              getKlasea()              Returns the current record's "Klasea" value
 * @method Mota                getMota()                Returns the current record's "Mota" value
 * @method Azpimota            getAzpimota()            Returns the current record's "Azpimota" value
 * @method Barrutia            getBarrutia()            Returns the current record's "Barrutia" value
 * @method Kalea               getKalea()               Returns the current record's "Kalea" value
 * @method Saila               getSaila()               Returns the current record's "Saila" value
 * @method Langilea            getLangilea()            Returns the current record's "Langilea" value
 * @method Egoera              getEgoera()              Returns the current record's "Egoera" value
 * @method Lehentasuna         getLehentasuna()         Returns the current record's "Lehentasuna" value
 * @method JatorrizkoSaila     getJatorrizkoSaila()     Returns the current record's "JatorrizkoSaila" value
 * @method Eraikina            getEraikina()            Returns the current record's "Eraikina" value
 * @method Doctrine_Collection getFitxategia()          Returns the current record's "Fitxategia" collection
 * @method Doctrine_Collection getIruzkina()            Returns the current record's "Iruzkina" collection
 * @method Doctrine_Collection getPlanifikazioa()       Returns the current record's "Planifikazioa" collection
 * @method Doctrine_Collection getGeo()                 Returns the current record's "Geo" collection
 * @method Gertakaria          setLaburpena()           Sets the current record's "laburpena" value
 * @method Gertakaria          setKlaseaId()            Sets the current record's "klasea_id" value
 * @method Gertakaria          setMotaId()              Sets the current record's "mota_id" value
 * @method Gertakaria          setAzpimotaId()          Sets the current record's "azpimota_id" value
 * @method Gertakaria          setAbisuaNork()          Sets the current record's "abisuaNork" value
 * @method Gertakaria          setEgoeraId()            Sets the current record's "egoera_id" value
 * @method Gertakaria          setSailaId()             Sets the current record's "saila_id" value
 * @method Gertakaria          setLangileaId()          Sets the current record's "langilea_id" value
 * @method Gertakaria          setBarrutiaId()          Sets the current record's "barrutia_id" value
 * @method Gertakaria          setKaleaId()             Sets the current record's "kalea_id" value
 * @method Gertakaria          setKaleZbkia()           Sets the current record's "kale_zbkia" value
 * @method Gertakaria          setDeskribapena()        Sets the current record's "deskribapena" value
 * @method Gertakaria          setIxteData()            Sets the current record's "ixte_data" value
 * @method Gertakaria          setHasieraAurreikusia()  Sets the current record's "hasiera_aurreikusia" value
 * @method Gertakaria          setAmaieraAurreikusia()  Sets the current record's "amaiera_aurreikusia" value
 * @method Gertakaria          setLehentasunaId()       Sets the current record's "lehentasuna_id" value
 * @method Gertakaria          setJatorrizkoSailaId()   Sets the current record's "jatorrizkoSaila_id" value
 * @method Gertakaria          setEraikinaId()          Sets the current record's "eraikina_id" value
 * @method Gertakaria          setKlasea()              Sets the current record's "Klasea" value
 * @method Gertakaria          setMota()                Sets the current record's "Mota" value
 * @method Gertakaria          setAzpimota()            Sets the current record's "Azpimota" value
 * @method Gertakaria          setBarrutia()            Sets the current record's "Barrutia" value
 * @method Gertakaria          setKalea()               Sets the current record's "Kalea" value
 * @method Gertakaria          setSaila()               Sets the current record's "Saila" value
 * @method Gertakaria          setLangilea()            Sets the current record's "Langilea" value
 * @method Gertakaria          setEgoera()              Sets the current record's "Egoera" value
 * @method Gertakaria          setLehentasuna()         Sets the current record's "Lehentasuna" value
 * @method Gertakaria          setJatorrizkoSaila()     Sets the current record's "JatorrizkoSaila" value
 * @method Gertakaria          setEraikina()            Sets the current record's "Eraikina" value
 * @method Gertakaria          setFitxategia()          Sets the current record's "Fitxategia" collection
 * @method Gertakaria          setIruzkina()            Sets the current record's "Iruzkina" collection
 * @method Gertakaria          setPlanifikazioa()       Sets the current record's "Planifikazioa" collection
 * @method Gertakaria          setGeo()                 Sets the current record's "Geo" collection
 * 
 * @package    gerkud
 * @subpackage model
 * @author     Pasaiako Udala
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGertakaria extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('gertakaria');
        $this->hasColumn('laburpena', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('klasea_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('mota_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('azpimota_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('abisuaNork', 'string', 512, array(
             'type' => 'string',
             'length' => 512,
             ));
        $this->hasColumn('egoera_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('saila_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('langilea_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('barrutia_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('kalea_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('kale_zbkia', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('deskribapena', 'string', 4000, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 4000,
             ));
        $this->hasColumn('ixte_data', 'datetime', null, array(
             'type' => 'datetime',
             'notnull' => false,
             ));
        $this->hasColumn('hasiera_aurreikusia', 'date', null, array(
             'type' => 'date',
             'notnull' => false,
             ));
        $this->hasColumn('amaiera_aurreikusia', 'date', null, array(
             'type' => 'date',
             'notnull' => false,
             ));
        $this->hasColumn('lehentasuna_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('jatorrizkoSaila_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('eraikina_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Klasea', array(
             'local' => 'klasea_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Mota', array(
             'local' => 'mota_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Azpimota', array(
             'local' => 'azpimota_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Barrutia', array(
             'local' => 'barrutia_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Kalea', array(
             'local' => 'kalea_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Saila', array(
             'local' => 'saila_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Langilea', array(
             'local' => 'langilea_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Egoera', array(
             'local' => 'egoera_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Lehentasuna', array(
             'local' => 'lehentasuna_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('JatorrizkoSaila', array(
             'local' => 'jatorrizkoSaila_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Eraikina', array(
             'local' => 'eraikina_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Fitxategia', array(
             'local' => 'id',
             'foreign' => 'gertakaria_id'));

        $this->hasMany('Iruzkina', array(
             'local' => 'id',
             'foreign' => 'gertakaria_id'));

        $this->hasMany('Planifikazioa', array(
             'local' => 'id',
             'foreign' => 'gertakaria_id'));

        $this->hasMany('Geo', array(
             'local' => 'id',
             'foreign' => 'gertakaria_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}