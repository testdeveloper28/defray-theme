<?php

namespace Dotsquares\Brand\Model\ResourceModel\Brands;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Dotsquares\Brand\Model\Brands', 'Dotsquares\Brand\Model\ResourceModel\Brands');
    }
}
