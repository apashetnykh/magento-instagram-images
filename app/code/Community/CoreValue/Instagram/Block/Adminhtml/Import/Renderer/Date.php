<?php

class CoreValue_Instagram_Block_Adminhtml_Import_Renderer_Date extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return Mage::getModel('core/date')->date('Y-m-d', $row->getData('instagram_created_time'));
    }
}