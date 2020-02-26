<?php

namespace Dotsquares\Blog\Model;

use Magento\Framework\DataObject\IdentityInterface;

class Contact extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'ws_products_grid';

    /**
     * @var string
     */
    protected $_cacheTag = 'ws_products_grid';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'ws_products_grid';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dotsquares\Blog\Model\ResourceModel\Contact');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getProducts(\Dotsquares\Blog\Model\Contact $object)
    {
		$tbl = $this->getResource()->getTable(\Dotsquares\Blog\Model\ResourceModel\Contact::TBL_ATT_PRODUCT);
			$select = $this->getResource()->getConnection()->select()->from(
				$tbl,
				['reviewid']
			)
			->where(
				'status = 1 and blogid = ?',
				(int)$object->getId()
			);
			#echo $select;
			return $this->getResource()->getConnection()->fetchCol($select);
    }
	
    public function getCustomerReview(\Dotsquares\Blog\Model\Contact $object)
    {
		#echo $object->getId(); die("model");
        $tbl = $this->getResource()->getTable('blog_review_position');
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['reviewid']
        )
        ->where(
            'blogid = ?',
            (int)$object->getId()
        );
		#echo $select;
        return $this->getResource()->getConnection()->fetchCol($select);
    }
}
