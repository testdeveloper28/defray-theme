<?php

namespace Dotsquares\Homepageslider\Block;

class Bannerslider extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Dotsquares\Homepageslider\Model\Items $bannerFactory,
        array $data = []
    ){
        $this->_bannerFactory = $bannerFactory;
        parent::__construct($context, $data);
    }
	
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}
	
	public function getBannerCollection()
	{
		$collection = $this->_bannerFactory->getCollection()
		->addFieldToFilter( 'status', '1' )
		->setOrder('sort_order', 'ASC');
		return $collection;
	}
}