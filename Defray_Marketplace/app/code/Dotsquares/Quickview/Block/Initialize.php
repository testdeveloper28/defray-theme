<?php
/**
 * @author Dotsquares Team
 * @copyright Copyright (c) 2015 Dotsquares (http://www.dotsquares.com)
 * @package Dotsquares_Quickview
 */
namespace Dotsquares\Quickview\Block;

class Initialize extends \Magento\Framework\View\Element\Template
{

	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Dotsquares\Quickview\Helper\Data $helper,
    array $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
    }

    public function getConfig()
    {
        return [
            'baseUrl' => $this->getBaseUrl()
        ];
    }

    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getUpdateCartUrl()
    {
        return $this->getUrl('quickview/index/updatecart');
    }
	
    public function getEnable() {
        return $this->helper->getConfig('dotsquares_quickview/general/enable');
    }
	
	public function getButtonstyle() {
        return $this->helper->getConfig('dotsquares_quickview/general/button_style');
    }
	
	public function getButtontextcolor() {
        return $this->helper->getConfig('dotsquares_quickview/general/button_textcolor');
    }
}
