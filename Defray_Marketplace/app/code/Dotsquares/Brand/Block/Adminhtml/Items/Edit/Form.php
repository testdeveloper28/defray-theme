<?php

namespace Dotsquares\Brand\Block\Adminhtml\Items\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    
    protected function _construct()
    {
        parent::_construct();
        $this->setId('dotsquares_items_form');
        $this->setTitle(__('Brand Information'));
    }

   
    protected function _prepareForm()
    {
       
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('brand/items/save'),
                    'method' => 'post',
					'enctype' => 'multipart/form-data',
                ],
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
