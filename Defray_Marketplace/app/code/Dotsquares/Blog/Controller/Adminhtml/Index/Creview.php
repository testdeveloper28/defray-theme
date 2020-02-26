<?php

namespace Dotsquares\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

class Creview extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param Action\Context $context
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) {
        parent::__construct($context);
        $this->_resultLayoutFactory = $resultLayoutFactory;
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
		$contactId = $this->getRequest()->getParam('id');
		$resultLayout = $this->_resultLayoutFactory->create();
		if($contactId){
			$resultLayout->getLayout()->getBlock('wsproductsgrid.edit.tab.products')
                     ->setInProducts($this->getRequest()->getPost('contact_products', null));
        	return $resultLayout;
		}else{
			die("No Records Found");	
		}
        
    }
}
