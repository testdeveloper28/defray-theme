<?php

namespace Dotsquares\Brand\Model\ResourceModel;

class Brands extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    protected function _construct()
    {
        $this->_init('ds_brand_items', 'brand_id');
    }
}
