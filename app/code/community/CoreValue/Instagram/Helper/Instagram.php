<?php

class CoreValue_Instagram_Helper_Instagram extends Mage_Core_Helper_Abstract
{
    private $settings = array();
    private $paramName = 'corevalue_instagram';
    private $dirName = 'corevalue_instagram';
    private $url = array(
        'authorize' => 'https://api.instagram.com/oauth/authorize/?client_id={clientId}&response_type=code&scope=public_content&redirect_uri={redirectUri}',
//        'recent'    => 'https://api.instagram.com/v1/tags/{tagName}/media/recent?access_token={accessToken}&count={count}'
        'recent'    => 'https://api.instagram.com/v1/users/self/media/recent?access_token={accessToken}&count={count}'
    );

    public function __construct()
    {
        $this->settings = array(
            '{tagName}'     => Mage::getStoreConfig('corevalueinstagram/settings/tag_name'),
            '{clientId}'    => Mage::getStoreConfig('corevalueinstagram/settings/client_id'),
            'clientSecret'  => Mage::getStoreConfig('corevalueinstagram/settings/client_secret'),
            '{accessToken}' => Mage::getStoreConfig('corevalueinstagram/settings/access_token'),
            '{count}'       => Mage::getStoreConfig('corevalueinstagram/settings/posts_count'),
            'imgResolution' => 'low_resolution'
        );
    }

    /**
     * Get settings
     * @return array
     */
    public function getSettings() {
        return $this->settings;
    }

    /**
     * Get data from session or request
     * @param null $ids
     * @return array
     */
    public function getData($ids = null)
    {
        return $ids ? $this->getDataTempStore($ids) : $this->getConvertedData();
    }

    /**
     * Set data in session
     * @param array $data
     */
    public function setTempStore(array $data)
    {
        $session = Mage::getSingleton('core/session');

        if ($session->getData($this->paramName)) {
            $session->unsetData($this->paramName);
        }

        $session->setData($this->paramName, $data);
    }

    /**
     * Download image by the url
     * @param null $url
     * @param $filename
     * @return string
     */
    public function downloadImage($url = null, $filename)
    {
        $path = $this->getMediaPath();

        $file = new Varien_Io_File();
        $file->checkAndCreateFolder($path);

        $client = new Zend_Http_Client();
        $client->setUri($url);
        $client->setMethod('GET');

        $request = $client->request();

        if ($request->getStatus() == 200) {
            $filename = $this->getFilename($request->getHeader('Content-type'), $filename);
            $file->filePutContent($path . $filename, $request->getBody());
        } else {
            $filename = '';
        }

        return $filename;
    }

    /**
     * Delete image from filesystem
     * @param $imagePath
     * @return bool
     */
    public function deleteImage($imagePath)
    {
        $file = new Varien_Io_File();
        return $file->rm($this->getMediaPath() . DS . $imagePath);
    }

    /**
     * @return string
     */
    public function getMediaPath()
    {
        return Mage::getBaseDir('media') . DS . 'custom' . DS . $this->dirName . DS;
    }

    /**
     * @return string
     */
    public function getMediaPathUrl()
    {
        return Mage::getBaseUrl('media') . 'custom' . DS . $this->dirName . DS;
    }

    /**
     * @param $contentType
     * @param $filename
     * @return string
     */
    private function getFilename($contentType, $filename)
    {
        $extension = $this->getExtensionFromContentType($contentType);
        return $filename . '.' . $extension;
    }

    /**
     * @param $contentType
     * @return mixed
     */
    private function getExtensionFromContentType($contentType)
    {
        return end(explode('/', $contentType));
    }

    /**
     * Convert data json (from instagram) to array
     * @return array
     */
    private function getConvertedData()
    {
        $result = array();
        $response = $this->getRawData();

        if (!$response) {
            return $result;
        }

        $response = json_decode($response);

        if (isset($response->data) && count($response->data)) {
            foreach ($response->data as $item) {
                $result[] = array(
                    'instagram_id' => $item->id,
                    'instagram_username' => $item->user->username,
                    'instagram_created_time' => $item->created_time,
                    'instagram_tags' => implode(', ', $item->tags),
                    'instagram_caption' => $item->caption->text,
                    'image_path' => '',
                    'image_url' => $item->images->{$this->settings['imgResolution']}->url
                );
            }
        }

        return $result;
    }

    /**
     * @return null|string
     */
    private function getRawData()
    {
        $response = null;

        $url = strtr($this->url['recent'], $this->settings);

        $client = new Zend_Http_Client();
        $client->setUri($url);
        $client->setMethod('GET');

        $request = $client->request();

        if ($request) {
            $response = $request->getBody();
        }

        return $response;
    }

    /**
     * @param array $ids
     * @return array
     */
    private function getDataTempStore(array $ids)
    {
        $result = array();
        $session = Mage::getSingleton('core/session');
        $data = $session->getData($this->paramName);

        if (is_array($data)) {
            foreach ($data as $item) {
                if (in_array($item['instagram_id'], $ids)) {
                    $result[] = $item;
                }
            }
        }

        return $result;
    }

    /**
     * Get JSON string for ajax response
     * @return string
     */
    public function getAjaxResponse()
    {
        $response = new stdClass();
        $response->items = array();

        $collection = Mage::getModel('corevalueinstagram/items')
            ->getCollection()
            ->addFieldToFilter(array('enabled'), array(1))
            ->setOrder('sort_order', 'DESC')
            ->setOrder('instagram_created_time', 'DESC');

        foreach ($collection as $item) {

            $products = array();
            $collectionItemProduct = $item->getCollectionItemProduct();

            foreach ($collectionItemProduct as $itemProduct) {
                $product = Mage::getModel('catalog/product')->load($itemProduct->getData('product_id'));
                $products[] = array(
                    'name'      => $product->getName(),
                    'url'       => $product->getProductUrl(),
                    'image_url' => $product->getImageUrl()
                );
            }

            $response->items[] = array(
                'id'            => $item->getData('id'),
                'image_url'     => $this->getMediaPathUrl() . $item->getData('image_path'),
                'description'   => $item->getData('instagram_caption'),
                'username'      => $item->getData('instagram_username'),
                'date'          => Mage::getModel('core/date')->date('Y-m-d', $item->getData('instagram_created_time')),
                'products'      => $products
            );
        }

        return json_encode($response);
    }

    /**
     * @return string
     */
    public function getSecretKeyForAuthorizeAction()
    {
        $sep = '/';
        $url = Mage::helper('adminhtml')->getUrl('corevalueinstagram/adminhtml_authorize');

        // Get secret key from url
        $parts = array_slice(explode($sep, $url), -2, -1);

        return implode($sep, $parts);
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        /*$url = Mage::helper('adminhtml')->getUrl('corevalueinstagram/adminhtml_authorize');
        $secretKey  = Mage::getSingleton('adminhtml/url')
            ->getSecretKey('corevalueinstagram','adminhtml_authorize');

        $search = Mage_Adminhtml_Model_Url::SECRET_KEY_PARAM_NAME . '/' . $secretKey . '/';
        $replace = '';

        return str_replace($search, $replace, $url);*/

        $url = Mage::getUrl('corevalueinstagram/adminhtml_authorize/index', null);

        return $url;
    }

    /**
     * @return string
     */
    public function getAuthorizationUrl()
    {
        $this->settings['{redirectUri}'] = $this->getRedirectUri();

        //$url = 'https://api.instagram.com/oauth/authorize/' .
            '?client_id={clientId}&response_type=code&scope=public_content&redirect_uri={redirectUri}';

        $url = strtr($this->url['authorize'], $this->settings);

        return $url;
    }

    /**
     * @param null $code
     */
    public function getAccessToken($code = null)
    {
        $client = new Zend_Http_Client();
        $client->setUri('https://api.instagram.com/oauth/access_token');
        $client->setMethod('POST');
        $client->setParameterPost(array(
            'client_secret' => $this->settings['clientSecret'],
            'client_id'     => $this->settings['{clientId}'],
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $this->getRedirectUri()
        ));

        try {
            $request = $client->request();

            if ($request) {
                $response = $request->getBody();

                $responseObject = json_decode($response);

                if (isset($responseObject->access_token)) {
                    Mage::getConfig()->saveConfig(
                        'corevalueinstagram/settings/access_token',
                        $responseObject->access_token
                    );
                } else {
                    Mage::log($response, null, 'corevalueinstagram.log');
                }
            }
        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, 'corevalueinstagram.log');
        }
    }
}