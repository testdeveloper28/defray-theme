<?php
namespace Dotsquares\Brand\Block\Adminhtml\Helper\Renderer;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $_storeManager;
   
    protected $brandModel;

    
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Dotsquares\Brand\Model\Brands $brandModel,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->brandModel = $brandModel;
    }

    
    public function render(\Magento\Framework\DataObject $row)
    {
        $storeViewId = $this->getRequest()->getParam('store');
        $brand = $this->brandModel->load($row->getId());
        $srcImage = $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ).$brand->getFilename();

        return '<image width="150" height="50" src ="'.$srcImage.'" alt="'.$brand->getFilename().'" title="'.$brand->getName().'" >';
    }
}
