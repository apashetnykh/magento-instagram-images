<?php

class CoreValue_Instagram_Block_Adminhtml_Items extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $helper = Mage::helper('corevalueinstagram');
        $this->_blockGroup = 'corevalueinstagram';
        $this->_controller = 'adminhtml_items';

        $this->_headerText = $helper->__('Instagram Posts');
        $this->removeButton('add');
    }

    public function _prepareLayout() {
        $this->removeButton('add');

        parent::_prepareLayout();
    }
}