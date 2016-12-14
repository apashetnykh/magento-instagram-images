<?php

class CoreValue_Instagram_Adminhtml_ImportController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/advancedmenu/corevalueinstagram/corevalueinstagramimport');
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function massSaveAction()
    {
        $items = $this->getRequest()->getParam('items', null);

        $result = array('error' => 0, 'success' => 0);

        $helperInstagram = Mage::helper('corevalueinstagram/instagram');

        $data = $helperInstagram->getData($items);

        if (is_array($data)) {
            foreach ($data as $item) {
                $item['image_path'] = $helperInstagram->downloadImage($item['image_url'], $item['instagram_id']);

                try {
                    Mage::getModel('corevalueinstagram/items')->setData($item)->save();
                    $result['success']++;
                } catch (Exception $e) {
                    $result['error']++;
                }
            }
        }

        if ($result['error']) {
            $this->_getSession()->addError($this->__('Total of %d items not have been imported', $result['error']));
        }

        if ($result['success']) {
            $this->_getSession()->addSuccess($this->__('Total of %d items have been imported', $result['success']));
            $this->_getSession()->addNotice($this->__('For viewing of the imported posts follow the <a href="%s">link</a>', $this->getUrl('*/adminhtml_items')));
        }

        $this->_redirect('*/adminhtml_import');
    }
}