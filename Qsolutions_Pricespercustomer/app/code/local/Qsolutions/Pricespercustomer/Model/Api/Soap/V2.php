<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Model_Api_Soap_V2 extends Mage_Api_Model_Resource_Abstract
{
    /**
     * @param $data
     * @param $storeId
     * @return $this
     * @throws Mage_Api_Exception
     */
    public function info($data, $storeId)
    {
        try {
            return Mage::helper('core')->jsonEncode(Mage::helper('qsolutions_pricespercustomer/api')->retrieve($data, $storeId));
        } catch (Mage_Core_Exception $e) {
            $this->_fault('error ', $e->getMessage());
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function items()
    {
        return Mage::helper('core')->jsonEncode(Mage::helper('qsolutions_pricespercustomer/api')->retrieveCollection());

    }

    /**
     * @param array $data
     * @return $this
     * @throws Exception
     * @throws Mage_Api_Exception
     */
    public function create(array $data)
    {
        $productId = $data['product_id'];
        $customerId = Mage::helper('qsolutions_pricespercustomer/api')->customerValidator($data['customer_id'], 1);
        $priceAdjustment = $data['price_adjustment'];
        $priceAdjustmentType = $data['price_adjustment_type'];

        try {
            /* @var $pricePerCustomer Qsolutions_Pricespercustomer_Model_Entity */
            $pricePerCustomer = Mage::getModel('qsolutions_pricespercustomer/entity');
            $pricePerCustomer->setProductId($productId);
            $pricePerCustomer->setCustomerId($customerId);
            $pricePerCustomer->setPriceAdjustmentType($priceAdjustmentType);
            $pricePerCustomer->setPriceAdjustment($priceAdjustment);

            $pricePerCustomer->save();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('data_invalid', $e->getMessage());
        }

        return $this;
    }

    /**
     * @param $customerId
     * @param $productId
     * @param array $data
     * @return $this
     */
    public function update($customerId, $productId, array $data)
    {
        $requiredParam = Mage::helper('qsolutions_pricespercustomer/api')->requiredParamValidator($productId, $customerId);

        $priceAdjustment = $data['price_adjustment'];
        $priceAdjustmentType = $data['price_adjustment_type'];

        try {
            if(isset($priceAdjustment)) {
                $requiredParam->setPriceAdjustment($priceAdjustment);
            }
            if(isset($priceAdjustmentType)) {
                $requiredParam->setPriceAdjustmentType($priceAdjustmentType);
            }
            $requiredParam->save();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('data_invalid', $e->getMessage());
        }

        return $this;
    }

    /**
     * @param $customerId
     * @param $productId
     * @return $this
     */
    public function delete($productId, $customerId)
    {
        $requiredParam = Mage::helper('qsolutions_pricespercustomer/api')->requiredParamValidator($productId, $customerId);

        try {
            $requiredParam->delete();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('error ', $e->getMessage());
        }

        return $this;
    }
}