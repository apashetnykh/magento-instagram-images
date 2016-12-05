<?php

class CoreValue_Instagram_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Send JSON for instagram block
     */
    public function indexAction()
    {
        $helperInstagram = Mage::helper('corevalueinstagram/instagram');

        $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json', true);
        $this->getResponse()->setBody($helperInstagram->getAjaxResponse());
    }
}