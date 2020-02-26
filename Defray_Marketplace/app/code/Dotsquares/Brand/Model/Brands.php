<?php

namespace Dotsquares\Brand\Model;

use Magento\Framework\DataObject\IdentityInterface;

class Brands extends \Magento\Framework\Model\AbstractModel
{
    protected $_productCollectionFactory;
    protected $_storeManager;
    protected $_url;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
		\Dotsquares\Brand\Model\ResourceModel\Brands $resource = null,
        \Dotsquares\Brand\Model\ResourceModel\Brands\Collection $resourceCollection = null,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Framework\UrlInterface $url,
        array $data = []
    )
    {
        $this->_storeManager = $storeManager;
        $this->_url = $url;
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
	
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Dotsquares\Brand\Model\ResourceModel\Brands');
    }
	
	public function getProductCollection()
    {
		$collection = $this->_productCollectionFactory->create()->addAttributeToSelect('*')->addAttributeToFilter('brand', ['eq' => $this->getOptionId()]);
        return $collection;
    }
}
