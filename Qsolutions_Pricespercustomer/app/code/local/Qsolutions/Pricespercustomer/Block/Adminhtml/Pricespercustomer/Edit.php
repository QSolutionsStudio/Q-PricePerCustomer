<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Block_Adminhtml_Pricespercustomer_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'qsolutions_pricespercustomer';
        $this->_controller = 'adminhtml_pricespercustomer';
        parent::__construct();

        $this->_addButton('goback', array(
            'label' => Mage::helper('qsolutions_pricespercustomer')->__('Back'),
            'onclick' => 'setLocation(\'' . $this->getBackUrl() .'\')',
            'class' => 'back',
        ), 20, -20);


        $this->removeButton('back');
        $this->removeButton('reset');
        $this->_updateButton('save', 'label', Mage::helper('qsolutions_pricespercustomer')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('qsolutions_pricespercustomer')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('qsolutions_pricespercustomer')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit()
            {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('pricespercustomer_data') && Mage::registry('pricespercustomer_data')->getId()) {
            return Mage::helper('qsolutions_pricespercustomer')->__("Edit", $this->escapeHtml(Mage::registry('pricespercustomer_data')->getTitle()));
        } else {
            return Mage::helper('qsolutions_pricespercustomer')->__('Add');
        }
    }
}