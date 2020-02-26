<?php

namespace Dotsquares\Homepageslider\Model\ResourceModel\Items;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    
    protected function _construct()
    {
        $this->_init('Dotsquares\Homepageslider\Model\Items', 'Dotsquares\Homepageslider\Model\ResourceModel\Items');
    }
}
