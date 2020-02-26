<?php namespace Dotsquares\Marketplace\Model;

class Advanced extends \Magento\CatalogSearch\Model\Advanced
{
	public function getSearchCriterias()
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$search = $this->_searchCriterias;
        if(isset($_GET['cat']) && is_numeric($_GET['cat'])) {
            $category = $objectManager->get('Magento\Catalog\Model\Category')->load($_GET['cat']);
            $search[] = array('name'=>'Category Name','value'=>$category->getName());
        }
        return $search;
    }
	
	public function getProductCollection()
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		if ($this->_productCollection === null) {
		    if(isset($_GET['cat']) && is_numeric($_GET['cat'])){
				$queryName = $_GET['name'];
				$catid = $_GET['cat'];
				$collectionFactory = $objectManager->get('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
				$collection = $collectionFactory->create();
				//$this->prepareProductCollection($collection);
				$categoryFactory = $objectManager->get('\Magento\Catalog\Model\CategoryFactory');
				$category = $categoryFactory->create()->load($catid);
 				$collection->addAttributeToSelect($objectManager->get('Magento\Catalog\Model\Config')->getProductAttributes())
                ->addMinimalPrice()
                ->addStoreFilter();
				$collection->addCategoryFilter($category);
				$collection->addAttributeToFilter(
                    [
                        ['attribute' => 'name', 'like' => '%'.$queryName.'%'],
                        ['attribute' => 'sku', 'like' => '%'.$queryName.'%']
                    ])->load();
				$this->_productCollection = $collection;
		    }else{
		    	$collection = $this->productCollectionFactory->create();
                $this->prepareProductCollection($collection);
                if (!$collection) {
                    return $collection;
                }
                $this->_productCollection = $collection;
		    }
			#echo '<pre>'; print_r($this->_productCollection->getSize());die("test");
		}
		return $this->_productCollection;
    }
	
	public function addFilters($values)
    {
        $attributes = $this->getAttributes();
        $allConditions = [];

        foreach ($attributes as $attribute) {
            /* @var $attribute Attribute */
            if (!isset($values[$attribute->getAttributeCode()])) {
                continue;
            }
            $value = $values[$attribute->getAttributeCode()];
            $preparedSearchValue = $this->getPreparedSearchCriteria($attribute, $value);
            if (false === $preparedSearchValue) {
                continue;
            }
            $this->addSearchCriteria($attribute, $preparedSearchValue);

            if ($attribute->getAttributeCode() == 'price') {
                $rate = 1;
                $store = $this->_storeManager->getStore();
                $currency = $store->getCurrentCurrencyCode();
                if ($currency != $store->getBaseCurrencyCode()) {
                    $rate = $store->getBaseCurrency()->getRate($currency);
                }

                $value['from'] = (isset($value['from']) && is_numeric($value['from']))
                    ? (float)$value['from'] / $rate
                    : '';
                $value['to'] = (isset($value['to']) && is_numeric($value['to']))
                    ? (float)$value['to'] / $rate
                    : '';
            }

            if ($attribute->getBackendType() == 'datetime') {
                $value['from'] = (isset($value['from']) && !empty($value['from']))
                    ? date('Y-m-d\TH:i:s\Z', strtotime($value['from']))
                    : '';
                $value['to'] = (isset($value['to']) && !empty($value['to']))
                    ? date('Y-m-d\TH:i:s\Z', strtotime($value['to']))
                    : '';
            }
            $condition = $this->_getResource()->prepareCondition(
                $attribute,
                $value,
                $this->getProductCollection()
            );
            if ($condition === false) {
                continue;
            }

            $table = $attribute->getBackend()->getTable();
            if ($attribute->getBackendType() == 'static') {
                $attributeId = $attribute->getAttributeCode();
            } else {
                $attributeId = $attribute->getId();
            }
            $allConditions[$table][$attributeId] = $condition;
        }
        if ($allConditions) {
			$this->_registry->register('advanced_search_conditions', $allConditions);
			if(isset($_GET['cat']) && is_numeric($_GET['cat'])){
				$this->getProductCollection();
			}else{
				$this->getProductCollection()->addFieldsToFilter($allConditions);
			}
        } else {
            throw new \Magento\Framework\Exception\LocalizedException(__('Please specify at least one search term.'));
        }

        return $this;
    }
}