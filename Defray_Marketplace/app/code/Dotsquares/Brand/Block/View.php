<?php

namespace Dotsquares\Brand\Block;

class View extends \Magento\Framework\View\Element\Template
{
    protected $_coreRegistry = null;
    protected $_catalogLayer;
    protected $_brandHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
		\Magento\Framework\ObjectManagerInterface $objectmanager,
        \Magento\Catalog\Block\Product\Context $catalogcontext,
		\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productcollection,
		\Magento\Framework\Url\Helper\Data $urlHelper,
		\Magento\Catalog\Model\Product\Attribute\Repository $productAttributeRepository,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
		\Dotsquares\Brand\Model\Brands $brands,
		\Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Registry $registry,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Catalog\Model\CategoryRepository $categoryRepository,
        array $data = []
    )
    {
        $this->_catalogLayer = $layerResolver->get();
        $this->_coreRegistry = $registry;
		$this->_productcollection = $productcollection;
		$this->_cartHelper = $catalogcontext->getCartHelper();
        $this->_catalogProductVisibility = $catalogProductVisibility;
		$this->urlHelper = $urlHelper;
		$this->_objectManager = $objectmanager;
		$this->_productFactory = $productFactory;
		$this->_productAttributeRepository = $productAttributeRepository;
		$this->brands = $brands;
		$this->categoryRepository = $categoryRepository;
		$this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    protected function _addBreadcrumbs()
    {
        $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();
        $brandRoute = 'brand';
        $pageTitle = 'Brand';
        $brand = $this->getCurrentBrand();
        $breadcrumbs->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link' => $baseUrl
            ]
        );
        $breadcrumbs->addCrumb(
            'mgs_brand',
            [
                'label' => $pageTitle,
                'title' => $pageTitle,
                'link' => $baseUrl . $brandRoute
            ]
        );
        $breadcrumbs->addCrumb(
            'brand',
            [
                'label' => $brand->getName(),
                'title' => $brand->getName(),
                'link' => ''
            ]
        );
    }

    public function getCurrentBrand()
    {
        $brand = $this->_coreRegistry->registry('current_brand');
        if ($brand) {
            $this->setData('current_brand', $brand);
        }
        return $brand;
    }

    public function getProductListHtml()
    {
        return $this->getChildHtml('product_list');
    }

	public  function getCategoryurl($categoryId)
    {
		$brand = $this->_coreRegistry->registry('current_brand');
		$option_id = $brand->getOptionId();
        $category = $this->categoryRepository->get($categoryId, $this->_storeManager->getStore()->getId());
        return $category->getUrl().'?brand='.$option_id;
    }
	
    public function getConfig($key, $default = '')
    {
        $result = $this->_brandHelper->getConfig($key);
        if (!$result) {
            return $default;
        }
        return $result;
    }

    protected function _prepareLayout()
    {
        $brand = $this->getCurrentBrand();
        $pageTitle = $brand->getName();
        $metaKeywords = $brand->getMetaKeywords();
        $metaDescription = $brand->getMetaDescription();
        $this->_addBreadcrumbs();
        if ($pageTitle) {
            $this->pageConfig->getTitle()->set($pageTitle);
        }
        if ($metaKeywords) {
            $this->pageConfig->setKeywords($metaKeywords);
        }
        if ($metaDescription) {
            $this->pageConfig->setDescription($metaDescription);
        }
        return parent::_prepareLayout();
    }

	public function getBrandProducts(){
		$brand = $this->getCurrentBrand();
		$option_id = $brand->getOptionId();
        $brandproduct = $this->_productcollection->create()->addAttributeToSelect('*')->addAttributeToFilter('brand',$option_id)->load();
		$catIds=[];
        $allCategories = array();
        foreach ($brandproduct as $product) {
        	$allCategories = array_merge($allCategories, $product->getCategoryIds());
        }
        $finalArray = array_unique($allCategories);
		return $finalArray;
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
	
    protected function _beforeToHtml()
    {
        return parent::_beforeToHtml();
    }
}