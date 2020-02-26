<?php

namespace Dotsquares\Blog\Model\ResourceModel;

class Review extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    protected function _construct()
    {
        $this->_init('blog_review', 'reviewid');
    }
}
