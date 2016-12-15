<?php
/**
 * @category Qsolutions
 * @package Q_Pricespercustomer
 * @author Michał Jóźwiak <jozef@qsolutionsstudio.com>
 */
class Q_Pricespercustomer_Model_Api2_Pricespercustomer_Rest_Admin_V1 extends Mage_Api2_Model_Resource
{
    /**
     * @return $this
     * @throws Exception
     * @throws Mage_Api2_Exception
     */
    public function _retrieve()
    {
        $data    = $this->getRequest()->getParam('data');
        $storeId = $this->getRequest()->getParam('store_id');

        try {
            return Mage::helper('q_pricespercustomer/api')->retrieve($data, $storeId);
        } catch (Mage_Core_Exception $e) {
            $this->_critical($e->getMessage(), Mage_Api2_Model_Server::HTTP_INTERNAL_ERROR);
        } catch (Exception $e) {
            $this->_critical(self::RESOURCE_UNKNOWN_ERROR);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function _retrieveCollection()
    {
        return Mage::helper('q_pricespercustomer/api')->retrieveCollection();
    }

    /**
     * @param array $data
     * @return $this
     * @throws Exception
     */
    public function _create(array $data)
    {
        $productId = $data['product_id'];
        $customerId = Mage::helper('q_pricespercustomer/api')->customerValidator($data['customer_id'], 1);
        $priceAdjustment = $data['price_adjustment'];
        $priceAdjustmentType = $data['price_adjustment_type'];

        try {
            /* @var $pricePerCustomer Q_Pricespercustomer_Model_Entity */
            $pricePerCustomer = Mage::getModel('q_pricespercustomer/entity');
            $pricePerCustomer->setProductId($productId);
            $pricePerCustomer->setCustomerId($customerId);
            $pricePerCustomer->setPriceAdjustmentType($priceAdjustmentType);
            $pricePerCustomer->setPriceAdjustment($priceAdjustment);

            $pricePerCustomer->save();
        } catch (Mage_Core_Exception $e) {
            $this->_critical($e->getMessage(), Mage_Api2_Model_Server::HTTP_INTERNAL_ERROR);
        } catch (Exception $e) {
            $this->_critical(self::RESOURCE_UNKNOWN_ERROR);
        }

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     * @throws Exception
     * @throws Mage_Api2_Exception
     */
    public function _update(array $data)
    {
        $productId = $this->getRequest()->getParam('data');
        $customerId = $this->getRequest()->getParam('customer_id');
        $requiredParam = Mage::helper('q_pricespercustomer/api')->requiredParamValidator($productId, $customerId);
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
            $this->_critical($e->getMessage(), Mage_Api2_Model_Server::HTTP_INTERNAL_ERROR);
        } catch (Exception $e) {
            $this->_critical(self::RESOURCE_UNKNOWN_ERROR);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     * @throws Mage_Api2_Exception
     */
    public function _delete()
    {
        $productId = $this->getRequest()->getParam('data');
        $customerId = $this->getRequest()->getParam('customer_id');

        $requiredParam = Mage::helper('q_pricespercustomer/api')->requiredParamValidator($productId, $customerId);

        try {
            $requiredParam->delete();
        } catch (Mage_Core_Exception $e) {
            $this->_critical($e->getMessage(), Mage_Api2_Model_Server::HTTP_INTERNAL_ERROR);
        } catch (Exception $e) {
            $this->_critical(self::RESOURCE_INTERNAL_ERROR);
        }

        return $this;
    }
}