<?php

namespace Dotsquares\Brand\Setup;


use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData  implements InstallDataInterface
{
	private $eavSetupFactory;
 
    
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        \Dotsquares\Brand\Model\BrandsFactory $brandFactory
	){
        $this->eavSetupFactory = $eavSetupFactory;
        $this->_brandFactory = $brandFactory;
    }
	
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
		
        $installer->startSetup();
        $table = $installer->getTable('ds_brand_items');
		if ($installer->getConnection()->isTableExists($table) != true)
		{
            $table = $installer->getConnection()->newTable($installer->getTable('ds_brand_items'))
            ->addColumn(
                'brand_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Brand Id'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['default' => null],
                'Name'
            )
            ->addColumn(
                'filename',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['default' => null],
                'Filename'
            ) 
			
			->addColumn(
                'optionlabel',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['default' => null],
                'Product Attribute option label'
            )
			->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['default' => 1, 'unsigned' => true],
                'Status'
            );
			$installer->getConnection()->createTable($table);
		}
		
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY, 'brand', 
			[
				'group'=> 'General',
				'type'=>'int',
				'backend'=>'',
				'frontend'=>'',
				'label'=>'Brand',
				'input'=>'select',
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
				'apply_to'=>'simple,configurable,grouped,virtual,bundle,downloadable',
				'option' => array (
                    'values' =>   array (
                        0 => 'Brand 1',
                        1 => 'Brand 2',
                        2 => 'Brand 3',
                        3 => 'Brand 4',
                        4 => 'Brand 5',
                        5 => 'Brand 6',
                    ),
                ),
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
					'catalog_product', $allSet, 'General', 'brand'
				);
			}
			
			$datas[] = [
		    	'name'       => "Brand 1",
		    	'filename'  => "brand/brand1.png",
		    	'optionlabel'=>'brand1',
		    	'status' => 1
		    ];
		    $datas[] = [
		    	'name'       => "Brand 2",
		    	'filename'  => "brand/brand2.png",
		    	'optionlabel'=>'brand2',
		    	'status' => 1
		    ];
		    $datas[] = [
		    	'name'       => "Brand 3",
		    	'filename'  => "brand/brand3.png",
		    	'optionlabel'=>'brand3',
		    	'status' => 1
		    ];
		    $datas[] = [
		    	'name'       => "Brand 4",
		    	'filename'  => "brand/brand4.png",
		    	'optionlabel'=>'brand4',
		    	'status' => 1
		    ];
		    $datas[] = [
		    	'name'       => "Brand 5",
		    	'filename'  => "brand/brand5.png",
		    	'optionlabel'=>'brand5',
		    	'status' => 1
		    ];
			$datas[] = [
		    	'name'       => "Brand 6",
		    	'filename'  => "brand/brand6.png",
		    	'optionlabel'=>'brand6',
		    	'status' => 1
		    ];
		    foreach($datas as $data){
		    	$brands = $this->_brandFactory->create();
		        $brands->addData($data)->save();
		    }
		$installer->endSetup();
    }
}
