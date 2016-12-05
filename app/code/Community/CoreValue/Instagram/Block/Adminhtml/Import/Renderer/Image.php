<?php
class CoreValue_Instagram_Block_Adminhtml_Import_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $img = $row->getData('image_url');

        $path = $img != '' ? '<img width="120" src="' . $img . '" />' : '';

        return $path;
    }
}