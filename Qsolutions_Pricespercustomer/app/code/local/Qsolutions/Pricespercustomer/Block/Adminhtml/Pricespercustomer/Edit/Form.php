<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Block_Adminhtml_Pricespercustomer_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $form->setUseContainer(true);
        $this->setForm($form);
        if (Mage::getSingleton('adminhtml/session')->getFormData()) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData();
            Mage::getSingleton('adminhtml/session')->setFormData(null);
        } elseif (Mage::registry('pricespercustomer_data')) {
            $data = Mage::registry('pricespercustomer_data')->getData();
        }

        $fieldset = $form->addFieldset('pricespercustomer_form', array('legend' => Mage::helper('qsolutions_pricespercustomer')->__('Customer Prices Information')));
        $actionname = $this->getRequest()->getActionName();
        if ($actionname == 'new') {
            $form->setValues($data);
        }

        $fieldset->addField('customer_id', 'text', array(
            'label' => Mage::helper('qsolutions_pricespercustomer')->__('Customer Id'),
            'required' => true,
            'name' => 'customer_id',
            'value' => $this->getRequest()->getParam('customerid'),
        ));

        $fieldset->addField('product_id', 'text', array(
            'label' => Mage::helper('qsolutions_pricespercustomer')->__('Product Id'),
            'required' => true,
            'name' => 'product_id',
            'title' => 'Produkt ID',
        ));

        $fieldset->addField('price_adjustment', 'text', array(
            'label' => Mage::helper('qsolutions_pricespercustomer')->__('Price'),
            'required' => true,
            'name' => 'price_adjustment',
            'title' => '0.00',
        ));

        $fieldset->addField('price_adjustment_type', 'select', array(
            'label' => Mage::helper('qsolutions_pricespercustomer')->__('Price Typ'),
            'required' => false,
            'name' => 'price_adjustment_type',
            'values' => array('1' => array(
                'value' => 'fix',
                'label' => 'Fix'
            ),
            )
        ));

        if ($actionname == 'edit') {
            $fieldset->addField('created_at', 'text', array(
                'label' => Mage::helper('qsolutions_pricespercustomer')->__('Created at'),
                'required' => false,
                'name' => 'created_at',
            ));
        }
        if ($actionname == 'edit') {
            $form->setValues($data);
        }
        return parent::_prepareForm();
    }
}