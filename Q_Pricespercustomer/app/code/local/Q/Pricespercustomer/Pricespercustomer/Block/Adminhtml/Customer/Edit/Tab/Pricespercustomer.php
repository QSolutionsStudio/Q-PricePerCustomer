<?php
/**
 * @category Qsolutions
 * @package Q_Pricespercustomer
 * @author Michał Jóźwiak <jozef@qsolutionsstudio.com>
 */
class Q_Pricespercustomer_Block_Adminhtml_Customer_Edit_Tab_Pricespercustomer
    extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('q/customer/options.phtml');
    }

    public function getCustomtabInfo() {
        $customTab = 'Content';
        return $customTab;
    }

    public function getCustomerId()
    {
        return Mage::registry('current_customer')->getId();
    }

    public function getTabLabel()
    {
        return $this->__('Prices For Customer');
    }

    public function getTabTitle()
    {
        return $this->__('Price Tab');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    public function getAfter()
    {
        return 'Tags';
    }

    public function getCustomerPrices() {
        $params = $this->getRequest()->getParams();
        $collection = Mage::getModel('q_pricespercustomer/entity')->getCollection();
        $collection->addFieldToFilter('customer_id', $params['id']);

        return $collection;
    }
}