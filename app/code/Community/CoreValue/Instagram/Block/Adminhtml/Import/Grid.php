<?php
class CoreValue_Instagram_Block_Adminhtml_Import_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareCollection()
    {
        $collection = new Varien_Data_Collection();
        $helperInstagram = Mage::helper('corevalueinstagram/instagram');

        $data = $helperInstagram->getData();
        
        $helperInstagram->setTempStore($data);

        if (is_array($data)) {
            foreach ($data as $item) {
                $object = new Varien_Object();
                $object->addData($item);
                $collection->addItem($object);
            }
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('corevalueinstagram');

        $this->addColumn('image', array(
            'align'     => 'center',
            'filter'    => false,
            'header'    => $helper->__('Image'),
            'index'     => 'image',
            'renderer'  => 'CoreValue_Instagram_Block_Adminhtml_Import_Renderer_Image'
        ));

        $this->addColumn('instagram_username', array(
            'filter'    => false,
            'header'    => $helper->__('Username'),
            'index'     => 'instagram_username'
        ));

        $this->addColumn('instagram_created_time', array(
            'filter'    => false,
            'header'    => $helper->__('Created date'),
            'index'     => 'instagram_created_time',
            'renderer'  => 'CoreValue_Instagram_Block_Adminhtml_Import_Renderer_Date'
        ));

        $this->addColumn('instagram_tags', array(
            'filter'    => false,
            'header'    => $helper->__('Tags'),
            'index'     => 'instagram_tags'
        ));

        $this->addColumn('instagram_caption', array(
            'filter'    => false,
            'header'    => $helper->__('Description'),
            'index'     => 'instagram_caption'
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('instagram_id');
        $this->getMassactionBlock()->setFormFieldName('items');

        $this->getMassactionBlock()->addItem('save', array(
            'label' => $this->__('Import'),
            'url' => $this->getUrl('*/*/massSave')
        ));

        return $this;
    }
}