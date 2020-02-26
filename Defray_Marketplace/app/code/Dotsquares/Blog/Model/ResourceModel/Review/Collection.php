<?php

namespace Dotsquares\Blog\Model\ResourceModel\Review;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    
    protected function _construct()
    {
        $this->_init('Dotsquares\Blog\Model\Review', 'Dotsquares\Blog\Model\ResourceModel\Review');
    }
}