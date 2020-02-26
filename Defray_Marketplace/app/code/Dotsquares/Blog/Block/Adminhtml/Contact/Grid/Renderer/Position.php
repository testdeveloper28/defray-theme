<?php
namespace Dotsquares\Blog\Block\Adminhtml\Contact\Grid\Renderer;

class Position extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $_storeManager;
	protected $connection;
    protected $resource; 
    
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
		
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
		$this->_resource = $resource;
    }

    /**
     * Render action.
     *
     * @param \Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
		$id = $row->getId();
		$connection = $this->getConnection();
		$tblSalesOrder = $connection->getTableName('blog_review_position');
		$select = $connection->select()->from(['o' =>  $tblSalesOrder])->where('o.reviewid=?',$id);
		$result = $connection->fetchAll($select);
		#echo '<pre>';print_r($result); die("test");
		if(empty($result)){
			$postion = '';
		}else{
			$postion = $result[0]['position'];
		}
		
		$storeViewId = $this->getRequest()->getParam('store');
        return '<input name="position['.$id.']" value="'.$postion.'"/>';
    }
	
	public function getConnection()
    {
        $connection = $this->_resource->getConnection('core_write');
        return $connection;
    }
}
