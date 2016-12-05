<?php

class CoreValue_Instagram_Adminhtml_AuthorizeController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Override preDispatch()
     */
    public function preDispatch()
    {
        $secret = Mage::helper('corevalueinstagram/instagram')->getSecretKeyForAuthorizeAction();
        $this->getRequest()->setParam(Mage_Adminhtml_Model_Url::SECRET_KEY_PARAM_NAME, $secret);

        parent::preDispatch();
    }

    /**
     * Get request from Instagram and save access token to config
     */
    public function indexAction()
    {
        $code = $this->getRequest()->getParam('code', null);

        if (!$code) {
            Mage::getSingleton('adminhtml/session')->addError('Instagram didn\'t return access token');
            $this->_redirect('adminhtml/system_config/edit/');
            return;
        }

        Mage::helper('corevalueinstagram/instagram')->getAccessToken($code);

        $this->_redirect('adminhtml/system_config/index');
    }
}