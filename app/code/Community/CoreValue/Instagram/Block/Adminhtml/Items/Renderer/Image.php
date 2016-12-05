<?php
class CoreValue_Instagram_Block_Adminhtml_Items_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $helperInstagram = Mage::helper('corevalueinstagram/instagram');
        $img = $row->getData('image_path');

        $path = $img != '' ? '<img width="120" src="' . $helperInstagram->getMediaPathUrl() . $img . '" />' : '';

        return  $path;
    }
}