<?php

namespace Dotsquares\Homepageslider\Block\Adminhtml\Items\Edit\Tab;


use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Dotsquares\Homepageslider\Model\Status;


class Main extends Generic implements TabInterface
{

    
    public function getTabLabel()
    {
        return __('Banner Information');
    }

    
    public function getTabTitle()
    {
        return __('Banner Information');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_dotsquares_homepageslider_items');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('item_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Banner Information')]);
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
        $fieldset->addField(
            'name',
            'text',
            ['name' => 'name', 'label' => __('Banner Name'), 'title' => __('Banner Name'), 'required' => true]
        );
		
		$fieldset->addField(
            'filename',
            'image',
            ['name' => 'filename', 'label' => __('Image'), 'title' => __('Image'), 'required' => true]
        );
		$fieldset->addField(
            'content',
            'textarea',
            ['name' => 'content', 'label' => __('Text'), 'title' => __('Text'), 'required' => true,'maxlength' => 200,'class' => 'validate-length']
        );
		
		$fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
				'values' => array('-1'=>'Please Select..','1' => 'Enable','0' => 'Disable'),
            ]
        );
		
		
		$fieldset->addField(
            'weblink',
            'text',
            ['name' => 'weblink', 'label' => __('Link'), 'title' => __('Link'), 'required' => false]
        );
		
		$fieldset->addField(
            'sort_order',
            'text',
            ['name' => 'sort_order', 'label' => __('Position'), 'title' => __('Position'), 'required' => true]
        );
		
		
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
