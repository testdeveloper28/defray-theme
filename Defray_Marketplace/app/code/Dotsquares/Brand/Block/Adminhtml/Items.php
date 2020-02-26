<?php

namespace Dotsquares\Brand\Block\Adminhtml;

class Items extends \Magento\Backend\Block\Widget\Grid\Container
{
    
    protected function _construct()
    {
        $this->_controller = 'items';
        $this->_headerText = __('Items');
        $this->_addButtonLabel = __('Add New Brand');
        parent::_construct();
    }
}
