<?php 

namespace Dotsquares\Blog\Controller\Index; 

use Magento\Framework\ObjectManagerInterface;
class Sumitreview extends \Magento\Framework\App\Action\Action
{
    
	
	protected $resultPageFactory;
    protected $reviewFactory;
	protected $_objectManager;
	
    public function __construct(
		\Magento\Framework\App\Action\Context $context,
		ObjectManagerInterface $_objectManager,
		\Dotsquares\Blog\Model\ResourceModel\Review\CollectionFactory $reviewFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
	)
	{
        $this->resultPageFactory = $resultPageFactory;
        $this->reviewFactory = $reviewFactory;
		$this->_objectManager = $_objectManager;
        parent::__construct($context);
    }
	
	public function execute()
    {
		
		$data =  $this->getRequest()->getParams();
		
		$data['status'] = 2;
		#echo '<pre>';print_r($data);die("test");
		$model = $this->_objectManager->create('Dotsquares\Blog\Model\Review');
		$model->setData($data);
		try {
				$model->save();
				$this->messageManager->addSuccess(__('Customer review successfully submitted.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the blog.'));
            }
	}
	
}