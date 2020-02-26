<?php


namespace Dotsquares\Homepageslider\Model\ResourceModel;

class Items extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('dotsquares_homepageslider_items', 'id');
    }
}
