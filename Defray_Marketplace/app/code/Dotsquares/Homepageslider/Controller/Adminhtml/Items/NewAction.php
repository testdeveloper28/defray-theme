<?php
namespace Dotsquares\Homepageslider\Controller\Adminhtml\Items;

class NewAction extends \Dotsquares\Homepageslider\Controller\Adminhtml\Items
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
