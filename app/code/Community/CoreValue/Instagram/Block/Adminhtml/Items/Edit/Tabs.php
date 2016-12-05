<?php

class CoreValue_Instagram_Block_Adminhtml_Items_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('item_info_tabs');
        $this->setDestElementId('item_edit_form');
        $this->setTitle(Mage::helper('corevalueinstagram')->__('Post Information'));
    }
    
    public function _prepareLayout() {
        $this->addTab('item_info', array(
            'label'     => Mage::helper('catalog')->__('Information'),
            'content'   => $this->_translateHtml($this->getLayout()
                ->createBlock('corevalueinstagram/adminhtml_items_edit_tab_info')->toHtml())
        ));

        $this->addTab('related_products', array(
            'label'     => Mage::helper('catalog')->__('Related Products'),
            'url'       => $this->getUrl('*/*/related', array('_current' => true)),
            'class'     => 'ajax',
        ));

        return parent::_prepareLayout();
    }

    protected function _translateHtml($html)
    {
        Mage::getSingleton('core/translate_inline')->processResponseBody($html);
        return $html;
    }
}