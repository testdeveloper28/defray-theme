<?php


namespace Dotsquares\Brand\Controller\Adminhtml\Items;

class NewAction extends \Dotsquares\Brand\Controller\Adminhtml\Items
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
