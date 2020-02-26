<?php
namespace Dotsquares\Brand\Model\Plugin;
 
class Productcollection
{
    public function afterAddCategoryIds(
        \Magento\Catalog\Model\ResourceModel\Product\Collection $subject,
        $result
    ) {
		if ($subject->getFlag('category_ids_added')) {
            return $subject;
        }
        $ids = array_keys($subject->getItems());
		if (empty($ids)) {
            return $subject;
        }
 
        $select = $subject->getConnection()->select();
 
        $select->from(
            $subject->getResource()->getTable('catalog_category_product'),
            ['product_id', 'category_id']
        );
        $select->where('product_id IN (?)', $ids);
 
        $data = $subject->getConnection()->fetchAll($select);
        $categoryIds = [];
        foreach ($data as $info) {
            if (isset($categoryIds[$info['product_id']])) {
                $categoryIds[$info['product_id']][] = $info['category_id'];
            } else {
                $categoryIds[$info['product_id']] = [$info['category_id']];
            }
        }
		foreach ($subject->getItems() as $item) {
            $productId = $item->getId();
			if (isset($categoryIds[$productId])) {
                $item->setCategoryIds($categoryIds[$productId]);
            } else {
		       $item->setCategoryIds([]);
            }
        }
		
        $subject->setFlag('category_ids_added', true);
        return $result;
    }
}