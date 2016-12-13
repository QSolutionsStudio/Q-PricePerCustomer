<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Adminhtml_PricespercustomerController
    extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return $this
     */
    public function indexAction()
    {
        $this->_title($this->__('Manage Prices Per Customer'));
        $this->loadLayout()
            ->_setActiveMenu('qsolutions_pricespercustomer/price')
            ->renderLayout();

        return $this;
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('qsolutions_pricespercustomer/price_per_customer');
    }

    /**
     * @return $this
     */
    public function editAction()
    {
        /* @var $model Qsolutions_Pricespercustomer_Model_Entity */
        $model = Mage::getModel('qsolutions_pricespercustomer/entity');

        $id = $this->getRequest()->getParam('id', null);
        if ($id) {
            $model->load((int) $id);

            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data);
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('qsolutions_pricespercustomer')->__('Item does not exist'));
                $this->_redirect('*/*/');
            }
        }
        Mage::register('pricespercustomer_data', $model);
        $this->loadLayout()->_setActiveMenu('qsolutions_pricespercustomer/price');
        $this->getLayout()
            ->getBlock('head')
            ->setCanLoadExtJs(true);
        $this->renderLayout();

        return $this;
    }

    /**
     *
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if ($data) {
            /* @var $model Qsolutions_Pricespercustomer_Model_Entity */
            $model = Mage::getModel('qsolutions_pricespercustomer/entity');

            if (array_key_exists('customer_id', $data)) {
                $customerId = $data['customer_id'];
            }

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            try {
                if ($id) {
                    $model->setId($id);
                }
                $model->save();
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('qsolutions_pricespercustomer')->__('Error saving price'));
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('qsolutions_pricespercustomer')->__('Price was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('qsolutions_pricespercustomer')->__('No data found to save'));
        };
        return $this->redirect($customerId, $model);
    }

    /**
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    public function deleteAction()
    {
        $customerId = null;
        try {
            $id = $this->getRequest()->getParam('id', null);
            /* @var $model Qsolutions_Pricespercustomer_Model_Entity */
            $model = Mage::getModel('qsolutions_pricespercustomer/entity')->load($id);
            $customerId = $model->getCustomerId();
            $model->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('qsolutions_pricespercustomer')->__('The price has been deleted'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        return $this->redirect($customerId);
    }

    /**
     * @param null $customerId
     * @param $model
     * @return $this|Mage_Core_Controller_Varien_Action
     */
    protected function redirect($customerId = null, $model)
    {
        $lastPage = Mage::getSingleton('adminhtml/session')->getLastPage();
        if ($this->getRequest()->getParam('back')) {
            return $this->_redirect('*/*/edit', array('id' => $model->getId()));
        } elseif ($lastPage === 'customer') {
            Mage::getSingleton('adminhtml/session')->unsLastPage();
            return $this->_redirect('/customer/edit/id/' . $customerId . '/key/' . Mage::getSingleton('adminhtml/url')->getSecretKey('adminhtml_customer', 'edit') . '/');
        } else {
            Mage::getSingleton('adminhtml/session')->unsLastPage();
            return $this->_redirect('*/*/');
        }
    }
}