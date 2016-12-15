<?php
/**
 * @category Qsolutions
 * @package Q_Pricespercustomer
 * @author Michał Jóźwiak <jozef@qsolutionsstudio.com>
 */
class Q_Pricespercustomer_Block_Adminhtml_Pricespercustomer
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        Mage::getSingleton('adminhtml/session')->setLastPage('no_customer');

        $this->_controller = 'adminhtml_pricespercustomer';
        $this->_blockGroup = 'q_pricespercustomer';
        $this->_headerText = Mage::helper('q_pricespercustomer')->__('Prices Define Per Customer');
        $this->_removeButton('add');

        parent::__construct();
    }
}