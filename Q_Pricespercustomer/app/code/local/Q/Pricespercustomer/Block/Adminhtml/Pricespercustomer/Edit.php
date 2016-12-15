<?php
/**
 * @category Qsolutions
 * @package Q_Pricespercustomer
 * @author Michał Jóźwiak <jozef@qsolutionsstudio.com>
 */
class Q_Pricespercustomer_Block_Adminhtml_Pricespercustomer_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'q_pricespercustomer';
        $this->_controller = 'adminhtml_pricespercustomer';
        parent::__construct();

        $backUrl = $this->getBackUrl();
        if ($this->getRequest()->getParam('customer_id')) {
            $backUrl = Mage::helper('adminhtml')->getUrl('adminhtml/customer/edit/index',array('id' => $this->getRequest()->getParam('customer_id')));;
        } elseif ($this->getRequest()->getParam('customerid')) {
            $backUrl = Mage::helper('adminhtml')->getUrl('adminhtml/customer/edit/index',array('id' => $this->getRequest()->getParam('customerid')));;
        }

        $this->_addButton('goback', array(
            'label' => Mage::helper('q_pricespercustomer')->__('Back'),
            'onclick' => 'setLocation(\'' . $backUrl .'\')',
            'class' => 'back',
        ), 20, -20);


        $this->removeButton('back');
        $this->removeButton('reset');
        $this->_updateButton('save', 'label', Mage::helper('q_pricespercustomer')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('q_pricespercustomer')->__('Delete'));

        if ($backUrl === $this->getBackUrl()) {
            $this->_addButton('saveandcontinue', array(
                'label' => Mage::helper('q_pricespercustomer')->__('Save And Continue Edit'),
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
    }

    public function getHeaderText()
    {
        if (Mage::registry('pricespercustomer_data') && Mage::registry('pricespercustomer_data')->getId()) {
            return Mage::helper('q_pricespercustomer')->__("Edit", $this->escapeHtml(Mage::registry('pricespercustomer_data')->getTitle()));
        } else {
            return Mage::helper('q_pricespercustomer')->__('Add');
        }
    }
}