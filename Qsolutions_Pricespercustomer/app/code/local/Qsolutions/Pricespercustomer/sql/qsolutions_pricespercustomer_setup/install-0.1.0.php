<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
$installer = $this;

$installer->startSetup();
$tableName = $installer->getTable('qsolutions_pricespercustomer/entity');
if (!($installer->getConnection()->isTableExists($tableName))) {
    $table = $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,),  'Entity Id')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0',), 'Customer Id')
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0',), 'Product Id')
        ->addColumn('price_adjustment', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
            'default' => '0.0',), 'Price Adjustment')
        ->addColumn('price_adjustment_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(), 'Price Adjustment Type')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,), 'Created At')
        ->addIndex($installer->getIdxName('qsolutions_pricespercustomer/entity', array( 'customer_id')), array('customer_id'))
        ->addIndex($installer->getIdxName('qsolutions_pricespercustomer/entity', array('product_id')), array('product_id'))
        ->addForeignKey($installer->getFkName('qsolutions_pricespercustomer/entity',
            'customer_id',
            'customer/entity', 'entity_id'),
            'customer_id', $installer->getTable('customer/entity'),
            'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey($installer->getFkName('qsolutions_pricespercustomer/entity',
            'product_id', 'catalog/product', 'entity_id'),
            'product_id', $installer->getTable('catalog/product'),
            'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ;

    $installer->getConnection()->createTable($table);
}

$installer->endSetup();