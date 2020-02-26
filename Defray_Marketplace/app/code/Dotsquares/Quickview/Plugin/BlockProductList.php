<?php

namespace Dotsquares\Quickview\Plugin;

class BlockProductList
{
    protected $urlInterface;
    protected $scopeConfig;
    public function __construct(
        \Magento\Framework\UrlInterface $urlInterface,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Catalog\Helper\Product\Compare $compareHelper,
		\Magento\Wishlist\Helper\Data $wishlistHelper,
		\Dotsquares\Quickview\Helper\Data $helper
        ) {
        $this->urlInterface = $urlInterface;
        $this->scopeConfig = $scopeConfig;
        $this->compareHelper = $compareHelper;
        $this->wishlistHelper = $wishlistHelper;
        $this->helper = $helper;
    }

    public function aroundGetProductDetailsHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product $product
    ){
        $result = $proceed($product);
        $isEnabled =$this->helper->getConfig('dotsquares_quickview/general/enable');
	    $buttonText =$this->helper->getConfig('dotsquares_quickview/general/button_text');
		$compareHepler = $this->compareHelper->getPostDataParams($product);
		$wishlistHelp = $this->wishlistHelper->getAddParams($product);
        if ($isEnabled) {
            $productUrl = $this->urlInterface->getUrl('quickview/catalog_product/view', array('id' => $product->getId()));
            
			return $result .'<div class="overlay"><ul><li><a class="quickview_anchor ds_quickview_button" data-quickview-url=' . $productUrl . ' href="javascript:void(0);"><i class="fa fa-search" aria-hidden="true"></i></a></li><li><a href="#"class="action tocompare"title="Add to Compare" aria-label="Add to Compare" data-post='.$compareHepler.' role="button"><i class="fa fa-refresh" aria-hidden="true"></i></a></li><li><a href="#" class="action towishlist" title="Add to Wishlist" aria-label="Add to Wishlist" data-post='.$wishlistHelp. 'data-action="add-to-wishlist" role="button"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li></ul></div>';
        }
        return $result;
    }
}