<?php
class CoreValue_Instagram_Block_Adminhtml_Items_Edit extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('corevalue/instagram/edit.phtml');
        //$this->setId('product_edit');
    }

    protected function _prepareLayout() {
        $this->setChild('save_button',
            $this->getLayout()
                ->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('corevalueinstagram')->__('Save'),
                    'onclick'   => 'itemForm.submit()',
                    'class'     => 'save'
                ))
        );

        return parent::_prepareLayout();
    }

    public function getItem()
    {
        return Mage::registry('current_item');
    }

    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('save_button');
    }

    public function getHeader() {
        return Mage::helper('corevalueinstagram')->__('Edit post');
    }

    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array('_current'=>true, 'back'=>null));
    }
}