<?php
namespace Dotsquares\Blog\Setup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Cms\Model\BlockFactory;
class InstallData implements InstallDataInterface
{
	protected $_bannerFactory;
	public function __construct(
	    \Dotsquares\Blog\Model\ContactFactory $blogFactory,
		\Magento\Framework\Stdlib\DateTime\DateTime $date,
		BlockFactory $blockFactory
	){
		$this->date = $date;
		$this->_blogFactory = $blogFactory;
		$this->blockFactory = $blockFactory;
	}
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$date = $this->date->gmtDate();
		$datas[] = [
			'name'       => "Kaytips : When in Dubaï",
			'logo'  => "blog/blog_1.jpg",
			'filename'    => '<img src="{{media url="blog/blog_1.jpg"}}" alt="" />We’re gonna be healthier, be better people, chase our dreams, go to the gym, learn a new language and everything we promise ourselves every year since 2011.',
			'description'     => 'Hi everyone!! It’s Fiona back here. First of all I hope you had a fantastic New Year’s Eve with all your beloved ones and that you started 2015 the right way. 2015 is the year! Can you feel it? We’re gonna be healthier, be better people, chase our dreams, go to the gym, learn a new language and everything we promise ourselves every year since 2011.',
			'short_description'    => 'Hi everyone!! It’s Fiona back here. First of all I hope you had a fantastic New Year’s Eve with all your beloved ones and that you started 2015 the right way. ',
			'created_time'=> $date,
			'update_time'=>$date,
			'message' => 'dotsquares',
			'devloper' => 'dotsquares',
			'sortorder' =>1,
			'status' => 1
		];
		$datas[] = [
			'name'       => "Kaytips : When in Dubaï",
			'logo'  => "blog/blog_2.jpg",
			'filename'    => '<img src="{{media url="blog/blog_1.jpg"}}" alt="" />We’re gonna be healthier, be better people, chase our dreams, go to the gym, learn a new language and everything we promise ourselves every year since 2011.',
			'description'     => 'Hi everyone!! It’s Fiona back here. First of all I hope you had a fantastic New Year’s Eve with all your beloved ones and that you started 2015 the right way. 2015 is the year! Can you feel it? We’re gonna be healthier, be better people, chase our dreams, go to the gym, learn a new language and everything we promise ourselves every year since 2011.',
			'short_description'    => 'Hi everyone!! It’s Fiona back here. First of all I hope you had a fantastic New Year’s Eve with all your beloved ones and that you started 2015 the right way. ',
			'created_time'=> $date,
			'update_time'=>$date,
			'message' => 'dotsquares',
			'devloper' => 'dotsquares',
			'sortorder' =>1,
			'status' => 1
		];
		foreach($datas as $data){
			$post = $this->_blogFactory->create();
		    $post->addData($data)->save();
		}
		
		/* $cmsBlockData = [
            'title' => 'Homepage Banner Slider ',
            'identifier' => 'homepage_banner_slider',
            'content' => '{{block class="Dotsquares\Homepageslider\Block\Bannerslider" template="Dotsquares_Homepageslider::homebanner/banner.phtml"}}',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
		
        $this->blockFactory->create()->setData($cmsBlockData)->save(); */
	}
}