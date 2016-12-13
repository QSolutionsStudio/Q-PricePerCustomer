<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Block_Adminhtml_Pricespercustomer
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        Mage::getSingleton('adminhtml/session')->setLastPage('no_customer');

        $this->_controller = 'adminhtml_pricespercustomer';
        $this->_blockGroup = 'qsolutions_pricespercustomer';
        $this->_headerText = Mage::helper('qsolutions_pricespercustomer')->__('Prices Define Per Customer');
        $this->_removeButton('add');

        parent::__construct();
    }
}