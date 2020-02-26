<?php

namespace Dotsquares\Homepageslider\Block\Adminhtml;

class Items extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'Banner Slider';
        $this->_headerText = __('Banner Slider');
        $this->_addButtonLabel = __('Add New Banner');
        parent::_construct();
    }
}
