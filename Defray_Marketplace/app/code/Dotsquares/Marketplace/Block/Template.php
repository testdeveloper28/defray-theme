<?php

namespace Dotsquares\Marketplace\Block;

class Template extends \Magento\Framework\View\Element\Template {
    public $_coreRegistry;
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
		\Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_customerSession = $customerSession;
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
	
	public function getSocialicon()
    {
        $socail_enable = $this->getConfig('marketplace_settings/header/header_social');
		if($socail_enable == 1){
			return $this->getConfig('marketplace_settings/header/header_social_block');
		}else{
			return false;
		}
    }
	
    /* public function getFooterLogoSrc(){
        $folderName = \Smartwave\Porto\Model\Config\Backend\Image\Logo::UPLOAD_DIR;
        $storeLogoPath = $this->_scopeConfig->getValue(
            'porto_settings/footer/footer_logo_src',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $path = $folderName . '/' . $storeLogoPath;
        $logoUrl = $this->_urlBuilder
                ->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]) . $path;
        return $logoUrl;
    } */
    public function isHomePage()
    {
        $currentUrl = $this->getUrl('', ['_current' => true]);
        $urlRewrite = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        return $currentUrl == $urlRewrite;
    }
    
	public function customerLogin()
    {
		return $this->_customerSession->isLoggedIn();
	}
}
?>