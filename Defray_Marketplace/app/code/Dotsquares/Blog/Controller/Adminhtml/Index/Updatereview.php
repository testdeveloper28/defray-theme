<?php

namespace Dotsquares\Blog\Controller\Adminhtml\Index;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\TestFramework\ErrorLog\Logger;

class Updatereview extends \Magento\Backend\App\Action
{
    protected $_jsHelper;
	
	protected $_contactCollectionFactory;
	
	public function __construct(
        Context $context,
        \Magento\Backend\Helper\Js $jsHelper,
        \Dotsquares\Blog\Model\ResourceModel\Contact\CollectionFactory $contactCollectionFactory
    ) {
        $this->_jsHelper = $jsHelper;
        $this->_contactCollectionFactory = $contactCollectionFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
		$resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
		$review = $this->_objectManager->create('Dotsquares\Blog\Model\Review');
		$reviewdata = $review->load($id);
		$status = $reviewdata->getStatus();
		if($status == 2){
			$reviewdata->setStatus(1);
		}else{
			$reviewdata->setStatus(2);
		}
		try {
				$reviewdata->save();
                $this->messageManager->addSuccess(__('Customer review status updated.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath($this->_redirect->getRefererUrl());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the blog.'));
				return $resultRedirect->setPath($this->_redirect->getRefererUrl());
            }
          
    }

   
}
