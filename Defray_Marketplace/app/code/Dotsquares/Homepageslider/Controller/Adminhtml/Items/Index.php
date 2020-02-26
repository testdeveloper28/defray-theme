<?php

namespace Dotsquares\Homepageslider\Controller\Adminhtml\Items;

class Index extends \Dotsquares\Homepageslider\Controller\Adminhtml\Items
{
    
    public function execute()
    {
        
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dotsquares_Homepageslider::homepageslider');
        $resultPage->getConfig()->getTitle()->prepend(__('Dotsquares Banner'));
        return $resultPage;
    }
}
