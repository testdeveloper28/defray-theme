<?php

namespace Dotsquares\Brand\Block\Adminhtml\Items\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    
    protected function _construct()
    {
        parent::_construct();
        $this->setId('dotsquares_brand_items_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Brand'));
    }
}
