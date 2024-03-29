<?php
/**
 * @category Qsolutions
 * @package Q_Pricespercustomer
 * @author Michał Jóźwiak <jozef@qsolutionsstudio.com>
 */
class Q_Pricespercustomer_Model_Resource_Entity
    extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('q_pricespercustomer/entity', 'entity_id');
    }

    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$object->getId()) {
            $object->setCreatedAt(now());
        }

        return parent::_beforeSave($object);
    }
}