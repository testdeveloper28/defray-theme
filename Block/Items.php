<?php
namespace Dotsquares\Featuredproducts\Block;
use Magento\Customer\Model\Context as CustomerContext;

class Items extends \Magento\Framework\View\Element\Template

{
	protected $_productcollection;
	protected $_catalogProductVisibility;
	protected $_cartHelper;
	 
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
		\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productcollection,
		\Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
    ) {
		$this->_productcollection = $productcollection;
		$this->_cartHelper = $context->getCartHelper();
        $this->_catalogProductVisibility = $catalogProductVisibility;
		$this->urlHelper = $urlHelper;
        parent::__construct($context);
    }
	
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}
	
	public function getFeaturedProducts(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection');
		$productCollection->addAttributeToFilter('is_featured',1);
		$productCollection->addAttributeToFilter('status',1);
		//echo $productCollection->getSelect();
		//die();
		return $productCollection;
	}
	
	public function getAddToCartUrl($product, $additional = [])
	{
		return $this->_cartHelper->getAddUrl($product, $additional);
	}
	
	public function getRatingSummary($product)
	{
		$this->_reviewFactory->create()->getEntitySummary($product, $this->_storeManager->getStore()->getId());
		$ratingSummary = $product->getRatingSummary()->getRatingSummary();
		return $ratingSummary;
	}
}
