<?php

$installer = $this;
$tableItems = $installer->getTable('corevalueinstagram/table_items');
$tableProducts = $installer->getTable('corevalueinstagram/table_products');

$installer->startSetup();

try {
    $installer->getConnection()->dropTable($tableItems);
    $installer->getConnection()->dropTable($tableProducts);

    // create items table
    $table = $installer->getConnection()
        ->newTable($tableItems)
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true
        ))
        ->addColumn('instagram_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable'  => false
        ), 'Instagram id')
        ->addColumn('instagram_username', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable'  => false
        ), 'Instagram username')
        ->addColumn('instagram_created_time', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable'  => false
        ), 'Instagram created time')
        ->addColumn('instagram_tags', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable'  => false,
        ), 'Instagram tags list')
        ->addColumn('instagram_caption', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable'  => false
        ), 'Instagram caption')
        ->addColumn('image_path', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable'  => false
        ), 'System path to file')
        ->addColumn('image_url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable'  => false
        ), 'Instagram image url')
        ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, 2, array(
            'nullable'  => false,
            'default'   => 0
        ), 'Sort Order')
        ->addColumn('enabled', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
            'nullable'  => false,
            'default'   => 1
        ), 'Enabled')
        ->addIndex(
            $installer->getIdxName(
                'corevalueinstagram/table_items',
                array('instagram_id'),
                Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
            ),
            array('instagram_id'),
            array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
        );

    $installer->getConnection()->createTable($table);

    // create products table
    $table = $installer->getConnection()
        ->newTable($tableProducts)
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true
        ))
        ->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable'  => true
        ))
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable'  => true
        ))
        ->addForeignKey(
            $installer->getFkName(
                'corevalueinstagram/table_products',
                'item_id',
                'corevalueinstagram/table_items',
                'id'
            ),
            'item_id',
            $installer->getTable('corevalueinstagram/table_items'),
            'id',
            Varien_Db_Ddl_Table::ACTION_CASCADE,
            Varien_Db_Ddl_Table::ACTION_CASCADE
        );

    $installer->getConnection()->createTable($table);

} catch (Exception $e) {
    Mage::log($e->getMessage());
}

$installer->endSetup();