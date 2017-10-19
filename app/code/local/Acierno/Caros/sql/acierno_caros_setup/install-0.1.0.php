<?php
/**
 * Acierno Carousell
 */

/**
 * Acierno Carousell Installer
 *
 * MySQL Installer.
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.1.0
 * @package Cms
 */

/* @var Mage_Core_Model_Resource_Setup $installer */


$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('acierno_caros/slider'))
    ->addColumn(
        'slider_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array('primary'=>true,'identity'=>true,'nullable'=>false),
        'Slider Id'
    )->addColumn(
        'name',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        64,
        array('nullable'=>false),
        'Slider name'
    )->addColumn(
        'images_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array('nullable'=>false),
        'Image ids, the "-" char will define difference'
    )->addColumn(
        'destination',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        64,
        array('nullable'=>false),
        'Image ids, the "," char will define difference'
    )->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_BOOLEAN,
        null,
        array('nullable'=>false),
        'Image status'
    )->addColumn(
        'showtitle',
        Varien_Db_Ddl_Table::TYPE_BOOLEAN,
        null,
        array('nullable'=>false),
        'Shows or not the title'
    )->addColumn(
        'titleposition',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        64,
        array('nullable'=>false),
        'Position of the title'
    )->addColumn(
        'active_from',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array('default'=>Varien_Db_Ddl_Table::TIMESTAMP_INIT),
        'Slider uploaded at'
    )->addColumn(
        'active_to',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array('default'=>Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE),
        'Slider updated at'
    )->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array('default'=>Varien_Db_Ddl_Table::TIMESTAMP_INIT),
        'Slider uploaded at'
    )->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array('default'=>Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE),
        'Slider updated at'
    );


$tableLookup= $installer->getConnection()
    ->newTable($installer->getTable('acierno_caros/images'))
    ->addColumn(
        'images_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array('primary'=>true,'identity'=>true,'nullable'=>false),
        'Slider Id'
    )->addColumn(
        'slider_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array('nullable'=>false),
        'Image ids, the "-" char will define difference'
    )->addColumn(
        'path',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        256,
        array('nullable'=>false,
        'Slider path for images'
        ));

$installer->getConnection()->createTable($table);
$installer->getConnection()->createTable($tableLookup);
$installer->endSetup();