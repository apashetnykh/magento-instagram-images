<?php

class CoreValue_Instagram_Block_Adminhtml_System_Config_Settings extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    /**
     * Render Redirect Uri field
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $helper = Mage::helper('corevalueinstagram/instagram');
        $redirectUri = $helper->getRedirectUri();
        $message = '<p class="switcher">' . $helper->__('Redirect Uri: ');
        $message .= '<strong>' . $redirectUri . '</strong>';

        return $message;
    }
}