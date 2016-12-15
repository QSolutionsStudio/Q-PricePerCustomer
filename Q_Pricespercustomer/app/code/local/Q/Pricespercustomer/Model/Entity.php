<?php
/**
 * @category Qsolutions
 * @package Q_Pricespercustomer
 * @author Michał Jóźwiak <jozef@qsolutionsstudio.com>
 */
class Q_Pricespercustomer_Model_Entity
    extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('q_pricespercustomer/entity');
    }
}