<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Model_Observer
{
    /**
     * @param $observer
     * @return $this
     */
    public function catalogProductCollectionLoadAfter($observer)
    {
        /* @var $observer Varien_Event_Observer */
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            foreach ($observer->getEvent()->getCollection() as $product) {
                $customer = Mage::getSingleton('customer/session')->getCustomer();
                $adjustment = $this->getCustomerPrices($customer->getEntityId(), $product->getEntityId());

                $finalPrice = $this->_adjustPrice($adjustment, $product->getFinalPrice());
                $product->setFinalPrice($finalPrice);
            }
        }

        return $this;
    }

    /**
     * @param $observer
     * @return $this
     */
    public function catalogProductGetFinalPrice($observer)
    {
        /* @var $observer Varien_Event_Observer */
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $product = $observer->getEvent()->getProduct();
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $adjustment = $this->getCustomerPrices($customer->getEntityId(), $product->getEntityId());

            $finalPrice = $this->_adjustPrice($adjustment, $product->getFinalPrice());
            $product->setFinalPrice($finalPrice);
        }

        return $this;
    }

    /**
     * @param array $adjustment
     * @param $price
     * @return mixed
     */
    protected function _adjustPrice($adjustment = array(), $price)
    {
        if (array_key_exists('price_adjustment', $adjustment) && $adjustment['price_adjustment']) {
            if ($adjustment['price_adjustment_type'] == 'Fix' || $adjustment['price_adjustment_type'] == 'fix') {
                if ($adjustment['price_adjustment'] < $price) {
                    $price = $adjustment['price_adjustment'];
                }
            } else {
                $price -= $price * ($adjustment['price_adjustment'] / 100);
            }
        }
        return $price;
    }

    /**
     * @param $cid
     * @param $pid
     * @return $this|mixed
     */
    protected function getCustomerPrices($cid, $pid)
    {
        /* @var $resource Mage_Core_Model_Resource */
        $resource = Mage::getSingleton('core/resource');

        $readConnection = $resource->getConnection('core_read');

        $qsolutionsPricePerCustomer = $readConnection->select()
            ->from(array('qppc' => $resource->getTableName('qsolutions_pricespercustomer/entity')))
            ->where("customer_id = ?", $cid)
            ->where("product_id = ?", $pid)
            ->order('created_at ASC')
        ;

        $pricePerCustomerCollection = $readConnection->fetchAll($qsolutionsPricePerCustomer);

        if (array_key_exists('0', $pricePerCustomerCollection)) {
            return reset($pricePerCustomerCollection);
        };

        return $this;
    }
}