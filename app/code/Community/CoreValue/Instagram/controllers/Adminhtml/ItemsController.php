<?php

class CoreValue_Instagram_Adminhtml_ItemsController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/advancedmenu/corevalueinstagram/corevalueinstagramitems');
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function editAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        Mage::register('current_item', Mage::getModel('corevalueinstagram/items')->load($id));

        $this->loadLayout();
        $this->renderLayout();
    }

    public function relatedAction()
    {
        $this->registerRelatedProducts();
        $this->loadLayout();
        $this->getLayout()->getBlock('corevalueinstagram.items.edit.tab.related')
            ->setProductsRelated($this->getRequest()->getPost('products_related', null));
        $this->renderLayout();
    }

    public function relatedGridAction()
    {
        $this->registerRelatedProducts();
        $this->loadLayout();
        $this->getLayout()->getBlock('corevalueinstagram.items.edit.tab.related')
            ->setProductsRelated($this->getRequest()->getPost('products_related', null));
        $this->renderLayout();
    }

    private function registerRelatedProducts()
    {
        $id = (int)$this->getRequest()->getParam('id');
        Mage::register('items_related_products',
            Mage::getModel('corevalueinstagram/products')
                ->getCollection()
                ->addFieldToFilter('item_id', $id)
        );
    }

    public function saveAction()
    {
        $productIds = null;
        $paramsItem = $this->getRequest()->getParam('corevalue_instagram_item');
        $id = (int)$this->getRequest()->getParam('id');
        $links = $this->getRequest()->getParam('links');

        if (isset($links['related'])) {
            $productIds = array_keys(
                Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['related'])
            );
        }

        if ($id) {
            try {
                if ($productIds !== null) {

                    /* delete old items */
                    $collection = Mage::getModel('corevalueinstagram/products')
                        ->getCollection()
                        ->addFieldToFilter('item_id', $id);

                    foreach ($collection as $item) {
                        $item->delete();
                    }

                    /* add new items */
                    foreach ($productIds as $productId) {
                        Mage::getModel('corevalueinstagram/products')
                            ->addData(array('item_id' => $id, 'product_id' => $productId))
                            ->save();
                    }
                }

                Mage::getModel('corevalueinstagram/items')->load($id)
                    ->addData($paramsItem)
                    ->save();

                $this->_getSession()->addSuccess($this->__('The post has been saved'));
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__('The post hasn\'t been saved'));
                Mage::logException($e);
            }
        }

        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        $items = $this->getRequest()->getParam('items', null);

        if (is_array($items) && sizeof($items) > 0) {
            try {
                foreach ($items as $id) {
                    Mage::getModel('corevalueinstagram/items')->setId($id)->delete();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d items have been deleted', sizeof($items)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        } else {
            $this->_getSession()->addError($this->__('Please select items'));
        }

        $this->_redirect('*/*');
    }
}