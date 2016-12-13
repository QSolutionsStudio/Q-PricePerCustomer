<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Block_Adminhtml_Pricespercustomer_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs
{
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('qsolutions_pricespercustomer')->__('Item Information'),
            'title' => Mage::helper('qsolutions_pricespercustomer')->__('Item Information'),
            'content' => $this->getLayout()->createBlock('qsolutions_pricespercustomer/adminhtml_pricespercustomer_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}