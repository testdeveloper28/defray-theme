<?php
namespace Dotsquares\Blog\Model\ResourceModel\Contact;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dotsquares\Blog\Model\Contact', 'Dotsquares\Blog\Model\ResourceModel\Contact');
    }
}
