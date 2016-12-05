<?php

class CoreValue_Instagram_Model_System_Config_Settings_AccessToken
{
    public function getCommentText()
    {
        $helper = Mage::helper('corevalueinstagram/instagram');

        $url = $helper->__('<a href="%s">Authorize application</a>', $helper->getAuthorizationUrl());
        
        return $url;
    }
}