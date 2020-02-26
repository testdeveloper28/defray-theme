<?php

namespace Dotsquares\Blog\Model;

class Review extends \Magento\Framework\Model\AbstractModel
{
    
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Dotsquares\Blog\Model\ResourceModel\Review');
    }
}
