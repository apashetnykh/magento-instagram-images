<?php

class CoreValue_Instagram_Block_Adminhtml_Import extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $helper = Mage::helper('corevalueinstagram');
        $this->_blockGroup = 'corevalueinstagram';
        $this->_controller = 'adminhtml_import';

        $this->_headerText = $helper->__('Import Instagram Posts');
    }

    public function _prepareLayout() {
        $this->removeButton('add');

        parent::_prepareLayout();
    }
}