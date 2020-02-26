<?php

namespace Dotsquares\Brand\Controller\Adminhtml\Items;

class Edit extends \Dotsquares\Brand\Controller\Adminhtml\Items
{

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Dotsquares\Brand\Model\Brands');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This item no longer exists.'));
                $this->_redirect('brand/*');
                return;
            }
        }
       
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $this->_coreRegistry->register('current_dotsquares_brand_items', $model);
        $this->_initAction();
        $this->_view->getLayout()->getBlock('items_items_edit');
		$this->_view->getPage()->getConfig()->getTitle()->set(__('Brands'));
        $this->_view->renderLayout();
    }
}
