<?php


class IruzkinaTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Iruzkina');
    }
}