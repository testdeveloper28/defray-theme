<?php
 
namespace Dotsquares\Marketplace\Setup;
 
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $blockFactory;
 
    public function __construct(BlockFactory $blockFactory)
    {
        $this->blockFactory = $blockFactory;
    }
 
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $cmsBlockDatas[] = [
            'title' => 'Defary Socail Icon',
            'identifier' => 'defary_header_socailicon',
            'content' => '<ul class="header socail_icon"><li class="fa fa-facebook"><a href="#">facebook</a></li><li class="fa fa-pinterest"><a href="#">pinterest</a></li><li class="fa fa-google-plus"><a href="#">google</a></li></ul>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $cmsBlockDatas[] = [
            'title' => 'Marketplace Fast Shipping',
            'identifier' => 'marketplace_shipping_block',
            'content' => '<div class="ds-aricle"> <div class="ds-artbox"> <ul> <li><i class="fa fa-rocket" aria-hidden="true"></i></li><li> <p>Fast &amp; Free Shiping</p><span>on all orders $99</span> </li></ul> </div><div class="ds-artbox"> <ul> <li><i class="fa fa-money" aria-hidden="true"></i></li><li> <p>100% Money Guarantee</p><span>30 days money back</span> </li></ul> </div><div class="ds-artbox"> <ul> <li><i class="fa fa-umbrella" aria-hidden="true"></i></li><li> <p>Safe shoping</p><span>Safe shopping Guarantee</span> </li></ul> </div><div class="ds-artbox"> <ul> <li><i class="fa fa-headphones" aria-hidden="true"></i></li><li> <p>Online Support</p><span>24*7 support</span> </li></ul> </div></div>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $cmsBlockDatas[] = [
            'title' => 'Marketplace Sales Marketing',
            'identifier' => 'marketplace_promotion_block',
            'content' => '<div class="promotion_content"><div class="ds-advertise"><div class="ds-advbox fleft"> <a href="#"> <img src="{{media url="wysiwyg/marketplace/adv1.jpg"}}" alt="" /></a> </div><div class="ds-advbox fright"> <a href="#"><img src="{{media url="wysiwyg/marketplace/adv2.jpg"}}" alt="" /> </a> </div></div><div class="clear"></div></div>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $cmsBlockDatas[] = [
            'title' => 'Footer Contact',
            'identifier' => 'footer_contact',
            'content' => '<h4>Contact</h4><address><ul><li><span class="footer_contact">Address</span> 444 Street Name, City, India</li><li><a href="tel:+123456789"><span class="footer_contact">Phone</span> (+123) 456789</a></li><li><a href="mailto:info@company.com"><span class="footer_contact">Email</span> info@company.com</a></li></ul></address>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $cmsBlockDatas[] = [
            'title' => 'Footer CUSTOMER',
            'identifier' => 'footer_customer',
            'content' => '<h4>CUSTOMER</h4><address><ul><li><span><i class="fa fa-angle-right"></i></span><a href="{{store url="about-us/"}}">About us</a></li><li><span><i class="fa fa-angle-right"></i></span><a href="{{store url="customer/account/login/"}}">My Account</a></li><li><span><i class="fa fa-angle-right"></i></span><a href="{{store url="contact/"}}">Contact us</a></li><li><span><i class="fa fa-angle-right"></i></span><a href="{{store url="catalogsearch/advanced/"}}">Advanced search</a></li><li><span><i class="fa fa-angle-right"></i></span><a href="{{store url="sales/guest/form/"}}">Orders and Returns</a></li></ul></address>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $cmsBlockDatas[] = [
            'title' => 'Footer Information',
            'identifier' => 'footer_information',
            'content' => '<h4>INFORMATION</h4><address><ul><li><span><i class="fa fa-angle-right" aria-hidden="true"></i></span><a href="#">Shipping & Returns</a></li><li><span><i class="fa fa-angle-right" aria-hidden="true"></i></span><a href="#">Secure Shopping</a></li><li><span><i class="fa fa-angle-right" aria-hidden="true"></i></span><a href="#">Order Status</a></li><li><span><i class="fa fa-angle-right" aria-hidden="true"></i></span><a href="#">International Shipping</a></li><li><span><i class="fa fa-angle-right" aria-hidden="true"></i></span><a href="#">Affiliates</a></li></ul></address>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $cmsBlockDatas[] = [
            'title' => 'Footer Social',
            'identifier' => 'footer_social',
            'content' => '<h4>We are social</h4><address><ul><li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li><li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li><li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li><li><a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a></li><li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li></ul></address>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
        $cmsBlockDatas[] = [
            'title' => 'Footer Cart Logo',
            'identifier' => 'footer-cart-logo',
            'content' => '<p><img src="{{media url="wysiwyg/footer/cards.jpg"}}" alt="" /></p>',
            'is_active' => 1,
            'stores' => [0],
            'sort_order' => 0
        ];
		foreach($cmsBlockDatas as $cmsBlockData){
			$identifier = $cmsBlockData['identifier'];
			$cmsBlock = $this->blockFactory->create()->load($identifier,'identifier');;
			if(!$cmsBlock->getId()){
			    $this->blockFactory->create()->setData($cmsBlockData)->save();
			}
		}
    }
}