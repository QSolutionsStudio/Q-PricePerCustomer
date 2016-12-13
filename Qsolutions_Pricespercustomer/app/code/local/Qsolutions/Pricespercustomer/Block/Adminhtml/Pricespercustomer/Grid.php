<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Block_Adminhtml_Pricespercustomer_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('pricespercustomer_pricespercustomer_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('qsolutions_pricespercustomer/entity')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Id'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'entity_id',
        ));
        $this->addColumn('customer_id', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Customer Id'),
            'align' => 'left',
            'index' => 'customer_id',
        ));
        $this->addColumn('product_id', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Product Id'),
            'align' => 'left',
            'index' => 'product_id',
        ));
        $this->addColumn('price_adjustment', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Price Adjustment'),
            'align' => 'left',
            'index' => 'price_adjustment',
        ));
        $this->addColumn('price_adjustment_type', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Price Typ'),
            'align' => 'left',
            'index' => 'price_adjustment_type',
        ));
        $this->addColumn('created_at', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Created'),
            'align' => 'left',
            'index' => 'created_at',
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('adminhtml/pricespercustomer/edit', array('id' => $row->getId()));
    }

    public function getMainButtonsHtml() {
        $html = parent::getMainButtonsHtml();
        $addButton = $this->getLayout()->createBlock('adminhtml/widget_button')
        ->setData(array(
            'label' => Mage::helper('qsolutions_pricespercustomer')->__('Create New Rule'),
            'onclick' => "setLocation('" . $this->getUrl('adminhtml/pricespercustomer/new', array()) . "')",
            'class' => 'task'
        ))->toHtml();
        return $addButton . $html;
    }
}