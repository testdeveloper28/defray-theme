<?php
namespace Dotsquares\Homepageslider\Setup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Cms\Model\BlockFactory;
class InstallData implements InstallDataInterface
{
	protected $_bannerFactory;
	public function __construct(
	    \Dotsquares\Homepageslider\Model\ItemsFactory $bannerFactory,
		\Magento\Framework\Stdlib\DateTime\DateTime $date,
		BlockFactory $blockFactory
	){
		$this->date = $date;
		$this->_bannerFactory = $bannerFactory;
		$this->blockFactory = $blockFactory;
	}
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$date = $this->date->gmtDate();
		$datas[] = [
			'name'       => "Banner1",
			'filename'  => "slider/slider_1.jpg",
			'content'    => 'banner1',
			'status'     => 1,
			'weblink'    => 'men.html',
			'sort_order' => 1,
			'created_time'=> $date,
			'update_time'=>$date
		];
		$datas[] = [
			'name'       => "Banner2",
			'filename'  => "slider/slider_2.jpg",
			'content'    => 'banner2',
			'status'     => 1,
			'weblink'    => 'women.html',
			'sort_order' => 1,
			'created_time'=> $date,
			'update_time'=>$date
		];
		foreach($datas as $data){
			$post = $this->_bannerFactory->create();
		    $post->addData($data)->save();
		}
		
		$cmsBlockData = [
            'title' => 'Homepage Banner Slider ',
            'identifier' => 'homepage_banner_slider',
            'content' => '{{block class="Dotsquares\Homepageslider\Block\Bannerslider" template="Dotsquares_Homepageslider::homebanner/banner.phtml"}}',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
		
        $this->blockFactory->create()->setData($cmsBlockData)->save();
	}
}