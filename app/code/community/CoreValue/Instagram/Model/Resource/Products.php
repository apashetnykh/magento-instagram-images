<?php

class CoreValue_Instagram_Model_Resource_Products extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('corevalueinstagram/table_products', 'id');
    }
}