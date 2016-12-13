<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Block_Adminhtml_Customer_Edit_Tab_Pricespercustomer_List
    extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareCollection()
    {
        Mage::getSingleton('adminhtml/session')->setLastPage('customer');

        $collection = Mage::getModel('qsolutions_pricespercustomer/entity')
            ->getCollection()
            ->addFieldToFilter('main_table.customer_id', $this->getRequest()->getParam('id'));
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return string
     */
    public function getAddButtonHtml()
    {
        return $this->getChildHtml('addButton');
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Id'),
            'width' => 50,
            'index' => 'entity_id',
            'sortable' => false,
        ));
        $this->addColumn('product_id', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Product Id'),
            'index' => 'product_id',
            'sortable' => false,
        ));
        $this->addColumn('price_adjustment', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Price'),
            'index' => 'price_adjustment',
            'sortable' => false,
        ));
        $this->addColumn('price_adjustment_type', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Price Typ'),
            'index' => 'price_adjustment_type',
            'sortable' => false,
        ));
        $this->addColumn('created_at', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Created'),
            'index' => 'created_at',
            'sortable' => false,
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('qsolutions_pricespercustomer')->__('Action'),
            'width' => '50px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('qsolutions_pricespercustomer')->__('Edit'),
                    'url' => array(
                        'base' => '*/pricespercustomer/edit',
                        'params' => array('store' => $this->getRequest()->getParam('store'))
                    ),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
        ));

        return parent::_prepareColumns();
    }

    /**
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        $link = $this->getUrl('*/pricespercustomer/edit', array(
                'id' => $row->getEntityId(),
                'customer_id' => $row->getCustomerId(),
            )
        );

        return $link;
    }

    /**
     * @return string
     */
    public function getMainButtonsHtml()
    {
        $html = parent::getMainButtonsHtml();

        $addButton = $this->getLayout()->createBlock('adminhtml/widget_button')
        ->setData(array(
            'label' => Mage::helper('qsolutions_pricespercustomer')->__('Create New Price'),
            'onclick' => "setLocation('" . $this->getUrl('adminhtml/pricespercustomer/new', array('customerid' => Mage::registry('current_customer')->getId())) . "')",
            'class' => 'task'
        ))->toHtml();

        return $addButton . $html;
    }
}