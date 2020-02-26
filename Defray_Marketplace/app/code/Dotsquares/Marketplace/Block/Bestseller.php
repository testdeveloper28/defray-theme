<?php

namespace Dotsquares\Marketplace\Block;

class Bestseller extends \Magento\Framework\View\Element\Template {
    public $_coreRegistry;
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
		\Magento\Reports\Model\ResourceModel\Report\Collection\Factory $bestsellerFactory,
		\Magento\Catalog\Model\ProductFactory $_productloader,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Checkout\Helper\Cart $cartHelper,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_bestsellerFactory = $bestsellerFactory;
		$this->_productloader = $_productloader;
		$this->_storeManager = $storeManager;
		$this->_cartHelper = $cartHelper;
        parent::__construct($context, $data);
    }
	
	Public function getCollection(){
		$collection = $this->_bestsellerFactory->create('\Magento\Sales\Model\ResourceModel\Report\Bestsellers\Collection'); 
        $collection->setPeriod('month');
        $product_ids = array();
		foreach ($collection as $item) {
            $product_ids[] = $item->getProductId();
        }
		return $product_ids;
	}
	public function getLoadProduct($id)
    {
		$product = $this->_productloader->create();
        $product->load($id);
		return $product;
    }
    
    public function getProductImageUrl($product)
    {
        return $this->_image->init($product, 'product_base_image')->constrainOnly(FALSE)
                    ->keepAspectRatio(TRUE)
                    ->keepFrame(FALSE)
                    ->getUrl();
    }
	/* public function getProductImageUrl()
    {
        return $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $this->getImage();
    } */
	public function getAddToCartUrl($product, $additional = [])
	{
		return $this->_cartHelper->getAddUrl($product, $additional);
	}
}
?>