<?php
/**
 * @category Qsolutions
 * @package Q_Pricespercustomer
 * @author Michał Jóźwiak <jozef@qsolutionsstudio.com>
 */
class Q_Pricespercustomer_Model_Resource_Entity_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('q_pricespercustomer/entity');
    }
}