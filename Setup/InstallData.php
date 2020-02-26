<?php
namespace Dotsquares\Featuredproducts\Setup;
 
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class InstallData implements InstallDataInterface
{
   
    private $eavSetupFactory;
 
    
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
 
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
 
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY, 'is_featured', [
            'group'=> 'General',
            'type'=>'int',
            'backend'=>'',
            'frontend'=>'',
            'label'=>'Featured Product',
            'input'=>'boolean',
            'class'=>'',
            'source'=>'',
            'global'=>\Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
            'visible'=>true,
            'required'=>false,
            'user_defined'=>true,
            'default'=>'',
            'searchable'=>false,
            'filterable'=>false,
            'comparable'=>false,
            'visible_on_front'=>true,
            'used_in_product_listing'=>true,
            'unique'=>false,
            'apply_to'=>'simple,configurable,grouped,virtual,bundle,downloadable'
           ]);
		   
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$collection = $objectManager->create('Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\Collection');
			$allAttributeSet = array();
			foreach($collection as $coll){
				if(!in_array($coll->getAttributeSetName(),$allAttributeSet)){
					$allAttributeSet[] = $coll->getAttributeSetName();
				}
			}
			foreach($allAttributeSet as $allSet){
				$eavSetup->addAttributeToSet(
					'catalog_product', $allSet, 'General', 'is_featured'
				);
			}
	}
}