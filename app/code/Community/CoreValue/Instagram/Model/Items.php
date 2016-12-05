<?php

class CoreValue_Instagram_Model_Items extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('corevalueinstagram/items');
    }

    public function _beforeDelete()
    {
        parent::_beforeDelete();
        $imagePath = $this->load($this->getId())->getData('image_path');
        Mage::helper('corevalueinstagram/instagram')->deleteImage($imagePath);
    }

    /**
     * Get collection ItemProducts
     * @return mixed
     */
    public function getCollectionItemProduct() {
        return Mage::getModel('corevalueinstagram/products')
            ->getCollection()
            ->addFieldToFilter('item_id', $this->getId());
    }

    /*public function _afterDelete() {
        $collection = Mage::getModel('corevalueinstagram/products')
            ->getCollection()
            ->addFieldToFilter('item_id', $this->getId());

        foreach ($collection as $item) {
            $item->delete();
        }
    }*/
}