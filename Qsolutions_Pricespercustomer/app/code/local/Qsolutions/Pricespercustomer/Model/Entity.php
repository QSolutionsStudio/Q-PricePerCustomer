<?php
/**
 * @category Qsolutions
 * @package Qsolutions_Pricespercustomer
 * @author Michał Jóźwiak <michalj@qsolutionsstudio.com>
 */
class Qsolutions_Pricespercustomer_Model_Entity
    extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('qsolutions_pricespercustomer/entity');
    }
}