<?php

class CoreValue_Instagram_Model_Resource_Items_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('corevalueinstagram/items');
    }
}