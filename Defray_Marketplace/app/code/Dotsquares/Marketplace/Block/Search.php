<?php

namespace Dotsquares\Marketplace\Block;

class Search extends \Magento\Framework\View\Element\Template {
    public $_coreRegistry;
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
		\Magento\Catalog\Model\CategoryRepository $categoryRepository,
		\Magento\Framework\App\Request\Http $request,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
		$this->categoryCollectionFactory = $categoryCollectionFactory;
		$this->categoryRepository = $categoryRepository;
		$this->_request = $request;
        parent::__construct($context, $data);
    }
    
    public function getConfig($config_path, $storeCode = null)
    {
        return $this->_scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeCode
        );
    }
	
	public function getParentscat()
    {
		/* $current_cat = $this->currentCategroy();
		if($current_cat == ''){
		    $parent_category_id = 2;
		}else{
			$parent_category_id = $current_cat;
		} */
		$parent_category_id = 2;
        $categoryObj = $this->categoryRepository->get($parent_category_id);
        $subcategories = $categoryObj->getChildrenCategories();
		$html = '';
        if($categoryObj->hasChildren()) {
            foreach($subcategories as $subcategorie) {
				if(isset($_GET['cat']) && $_GET['cat'] == $subcategorie->getId()){
					$html .= '<option value="'.$subcategorie->getId().'" selected="selected">'.$subcategorie->getName().'</option>';
				}else{
					$html .= '<option value="'.$subcategorie->getId().'">'.$subcategorie->getName().'</option>';
				}
            }
        }else{
			$categoryObj = $this->categoryRepository->get(2);
            $subcategories = $categoryObj->getChildrenCategories();
			foreach($subcategories as $subcategorie) {
                $html .= '<option value="'.$subcategorie->getId().'">'.$subcategorie->getName().'</option>';
            }
		}
		return $html;
    }
	
	public function getSearchPostUrl()
    {
        return $this->getUrl('catalogsearch/advanced/result');
    }
	
	public function currentCategroy()
    {
        if ($this->_request->getFullActionName() == 'catalog_category_view') {
            $category = $this->_coreRegistry->registry('current_category');
			return $category->getId();
        }else if ($this->_request->getFullActionName() == 'catalog_product_view') {
            return false;
        }else{
			return false;
		}
		
	}
	public function getDescendants($category, $levels = 2)
    {
        if ((int)$levels < 1) {
            $levels = 1;
        }
        $collection = $this->categoryCollectionFactory->create()
              ->addPathsFilter($category->getPath().'/') 
              ->addLevelFilter($category->getLevel() + $levels);
		#echo '<pre>'; print_r($collection->getData());die("testt");
        return $collection;
    }
	
    public function isHomePage()
    {
        $currentUrl = $this->getUrl('', ['_current' => true]);
        $urlRewrite = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        return $currentUrl == $urlRewrite;
    }
}
?>