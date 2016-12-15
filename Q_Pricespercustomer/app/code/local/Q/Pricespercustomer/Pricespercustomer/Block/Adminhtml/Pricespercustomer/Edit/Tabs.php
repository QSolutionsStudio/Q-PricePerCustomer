<?php
/**
 * @category Qsolutions
 * @package Q_Pricespercustomer
 * @author Michał Jóźwiak <jozef@qsolutionsstudio.com>
 */
class Q_Pricespercustomer_Block_Adminhtml_Pricespercustomer_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs
{
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('q_pricespercustomer')->__('Item Information'),
            'title' => Mage::helper('q_pricespercustomer')->__('Item Information'),
            'content' => $this->getLayout()->createBlock('q_pricespercustomer/adminhtml_pricespercustomer_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}