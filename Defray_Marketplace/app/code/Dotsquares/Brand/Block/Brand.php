<?php

namespace Dotsquares\Brand\Block;

class Brand extends \Magento\Framework\View\Element\Template
{
   
	protected $_productcollection;
	protected $_catalogProductVisibility;
	protected $_cartHelper;
	 
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\ObjectManagerInterface $objectmanager,
        \Magento\Catalog\Block\Product\Context $catalogcontext,
		\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productcollection,
		\Magento\Framework\Url\Helper\Data $urlHelper,
		\Magento\Catalog\Model\Product\Attribute\Repository $productAttributeRepository,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
		\Dotsquares\Brand\Model\Brands $brands
    ) {
		$this->_productcollection = $productcollection;
		$this->_cartHelper = $catalogcontext->getCartHelper();
        $this->_catalogProductVisibility = $catalogProductVisibility;
		$this->urlHelper = $urlHelper;
		$this->_objectManager = $objectmanager;
		$this->_productAttributeRepository = $productAttributeRepository;
		$this->brands = $brands;
        parent::__construct($context);
    }
	
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}
	
	public function getBrandProducts(){
		$brandId = (int)$this->getRequest()->getParam('brand_id', false);
		$bname = $this->brands->load($brandId)->getName();
		$brandOptions = $this->_productAttributeRepository->get('brand')->getOptions();
		foreach ($brandOptions as $brandOption) {
            $option_label = $brandOption->getLabel();
			if($option_label == $bname){
				$option_id = $brandOption->getValue();
        	    $brandproduct = $this->_productcollection->create()->addAttributeToSelect('*')->addAttributeToFilter('brand',$option_id);
				break;
			}
		}
		return $brandproduct;
	}	
	
	public function getAddToCartUrl($product, $additional = [])
	{
		return $this->_cartHelper->getAddUrl($product, $additional);
	}
	
	public function getImageMediaPath(){
    	return $this->getUrl('pub/media',['_secure' => $this->getRequest()->isSecure()]);
    }
	
	public function getBrandcollection()
	{
		return $this->brands->getCollection()->addFieldToFilter('status',1);
	}
	
}