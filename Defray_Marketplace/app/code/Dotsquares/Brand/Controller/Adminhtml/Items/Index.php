<?php

namespace Dotsquares\Brand\Controller\Adminhtml\Items;

class Index extends \Dotsquares\Brand\Controller\Adminhtml\Items
{
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dotsquares_Brand::brand');
        $resultPage->getConfig()->getTitle()->set(__('Brands'));
        return $resultPage;
    }
}
