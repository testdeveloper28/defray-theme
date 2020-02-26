<?php
namespace Dotsquares\Homepageslider\Controller\Adminhtml;

abstract class Items extends \Magento\Backend\App\Action
{
    
    protected $_coreRegistry;

    
    protected $resultForwardFactory;

    
    protected $resultPageFactory;

    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    
    protected function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Dotsquares_Homepageslider::items')->_addBreadcrumb(__('Items'), __('Items'));
        return $this;
    }

    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dotsquares_Homepageslider::items');
    }
}
