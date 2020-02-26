<?php

namespace Dotsquares\Homepageslider\Block\Adminhtml\Items\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('dotsquares_items_form');
        $this->setTitle(__('Banner Information'));
    }

    protected function _prepareForm()
    {
    
		$form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('dotsquares_homepageslider/items/save'),
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
