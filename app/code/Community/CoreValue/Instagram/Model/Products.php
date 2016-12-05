<?php

class CoreValue_Instagram_Model_Products extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('corevalueinstagram/products');
    }
}