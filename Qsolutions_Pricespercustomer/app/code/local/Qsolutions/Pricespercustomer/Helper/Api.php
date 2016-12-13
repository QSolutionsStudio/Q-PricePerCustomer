<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Helper_Api
    extends Mage_Core_Helper_Abstract
{
    /**
     * @param $data
     * @param $storeId
     * @return mixed
     */
    public function retrieve($data, $storeId)
    {
        $customerId = $this->customerValidator($data, $storeId);

        /* @var $pricePerCustomer Qsolutions_Pricespercustomer_Model_Entity */
        $pricePerCustomer = Mage::getModel('qsolutions_pricespercustomer/entity')->load($customerId, 'customer_id');

        return $pricePerCustomer->toArray();

    }

    /**
     * @return mixed
     */
    public function retrieveCollection()
    {
        return Mage::getModel('qsolutions_pricespercustomer/entity')->getCollection()->getData();
    }

    /**
     * @param $productId
     * @param $customerId
     * @return Qsolutions_Pricespercustomer_Model_Entity
     * @throws Exception
     */
    public function requiredParamValidator($productId, $customerId)
    {
        if(!isset($productId)) {
            throw new Exception('Undefined index: product_id');
            exit;
        }

        if(!isset($customerId)) {
            throw new Exception('Undefined index: customer_id');
            exit;
        }

        /* @var $pricePerCustomer Qsolutions_Pricespercustomer_Model_Entity */
        $pricePerCustomer = Mage::getModel('qsolutions_pricespercustomer/entity')
            ->load($customerId, 'customer_id')
            ->load($productId, 'product_id')
        ;

        return $pricePerCustomer;
    }

    /**
     * @param $data
     * @param null $storeId
     * @return mixed
     */
    public function customerValidator($data, $storeId = null)
    {
        if(is_null($storeId)) {
            $storeId = $this->getDefaultStoreId();
        }
        if(filter_var($data, FILTER_VALIDATE_EMAIL)) {
            $customer = Mage::getModel("customer/customer");
            $customer->setWebsiteId($storeId);
            $customer->loadByEmail($data);

            return $customer->getEntityId();
        } elseif(is_numeric($data)) {
            return $data;
        }
    }

    /**
     * @return int|null|string
     */
    public function getDefaultStoreId()
    {
        return Mage::app()->getDefaultStoreView()->getWebsiteId();
    }
}