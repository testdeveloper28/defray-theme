<?php

namespace Dotsquares\Blog\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $_backendUrl;

    protected $storeManager;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->storeManager = $storeManager;
    }

    public function getCustomerGridUrl()
    {
        return $this->_backendUrl->getUrl('blog/index/creview', ['_current' => true]);
    }
}
