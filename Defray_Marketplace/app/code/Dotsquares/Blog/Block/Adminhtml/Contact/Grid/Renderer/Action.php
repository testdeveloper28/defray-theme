<?php
namespace Dotsquares\Blog\Block\Adminhtml\Contact\Grid\Renderer;

class Action extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $_storeManager;
   
    protected $reviewModel;

    
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Dotsquares\Blog\Model\Review $reviewModel,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->reviewModel = $reviewModel;
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        $storeViewId = $this->getRequest()->getParam('store');
        $review = $this->reviewModel->load($row->getId());
		$status = $review->getStatus();
		if($status == 1){
			return '<a href="'.$this->getUrl('*/*/updatereview').'id/'.$row->getId().'">Disable</a>';
		}else{
			return '<a href="'.$this->getUrl('*/*/updatereview').'id/'.$row->getId().'">Enable</a>';
		}
        
    }
}