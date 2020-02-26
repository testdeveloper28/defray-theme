<?php
namespace Dotsquares\Homepageslider\Model;

class Items extends \Magento\Framework\Model\AbstractModel
{
	
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Dotsquares\Homepageslider\Model\ResourceModel\Items');
    }
}
