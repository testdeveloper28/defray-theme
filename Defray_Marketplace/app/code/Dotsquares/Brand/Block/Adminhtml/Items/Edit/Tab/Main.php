<?php

namespace Dotsquares\Brand\Block\Adminhtml\Items\Edit\Tab;


use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;



class Main extends Generic implements TabInterface
{

    
    public function getTabLabel()
    {
        return __('Brand Information');
    }

    
    public function getTabTitle()
    {
        return __('Brand Information');
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
        $model = $this->_coreRegistry->registry('current_dotsquares_brand_items');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('item_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Brand Information')]);
        if ($model->getId()) {
            $fieldset->addField('brand_id', 'hidden', ['name' => 'brand_id']);
        }
        $fieldset->addField(
            'name',
            'text',
            ['name' => 'name', 'label' => __('Brand Name'), 'title' => __('Brand Name'), 'required' => true]
        );
		
		/* ---------- */
		$fieldset->addField(
            'filename',
            'image',
            ['name' => 'filename', 'label' => __('Image'), 'title' => __('Image'), 'required' => true]
        );
		$fieldset->addField(
            'optionlabel',
            'text',
            ['name' => 'optionlabel', 'label' => __('Brand option label'), 'title' => __('Brand option label'), 'comment'=>__("Enter option's label of brand attribute"), 'required' => true]
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
		
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
