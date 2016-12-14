<?php

class CoreValue_Instagram_Block_Adminhtml_Items_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('corevalueinstagram/items')->getCollection();

        // Set custom sorting
        $collection
            ->setOrder('enabled', 'DESC')
            ->setOrder('sort_order', 'DESC')
            ->setOrder('instagram_created_time', 'DESC');

        $this->setCollection($collection);

        /*$this->setDefaultSort('sort_order');
        $this->setDefaultDir('ASC');*/

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('corevalueinstagram');

        $this->addColumn('image', array(
            'align'     => 'center',
            'sortable'  => false,
            'filter'    => false,
            'header'    => $helper->__('Image'),
            'index'     => 'image',
            'renderer'  => 'CoreValue_Instagram_Block_Adminhtml_Items_Renderer_Image'
        ));

        $this->addColumn('instagram_caption', array(
            'sortable'  => false,
            'filter'    => false,
            'header'    => $helper->__('Description'),
            'index'     => 'instagram_caption'
        ));

        $this->addColumn('instagram_username', array(
            'sortable'  => false,
            'filter'    => false,
            'header'    => $helper->__('Username'),
            'index'     => 'instagram_username'
        ));

        $this->addColumn('sort_order', array(
            'sortable'  => false,
            'filter'    => false,
            'header'    => $helper->__('Sort Order'),
            'index'     => 'sort_order'
        ));

        $this->addColumn('instagram_created_time', array(
            'sortable'  => false,
            'filter'    => false,
            'header'    => $helper->__('Created date'),
            'index'     => 'instagram_created_time',
            'renderer'  => 'CoreValue_Instagram_Block_Adminhtml_Import_Renderer_Date'
        ));

        $this->addColumn('enabled', array(
            'sortable'  => false,
            'filter'    => false,
            'header'    => $helper->__('Enabled'),
            'index'     => 'enabled'
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('items');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('corevalueinstagram')->__("Are you sure?")
        ));
        
        return $this;
    }

    public function getRowUrl($model)
    {
        return $this->getUrl('*/*/edit', array(
            'id' => $model->getId()
        ));
    }
}