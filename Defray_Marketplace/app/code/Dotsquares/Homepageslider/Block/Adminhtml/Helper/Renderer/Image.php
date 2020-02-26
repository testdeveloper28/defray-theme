<?php
namespace Dotsquares\Homepageslider\Block\Adminhtml\Helper\Renderer;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $_storeManager;
   
    protected $sliderModel;

    
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Dotsquares\Homepageslider\Model\Items $sliderModel,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->sliderModel = $sliderModel;
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
        $storeViewId = $this->getRequest()->getParam('store');
        $slider = $this->sliderModel->load($row->getId());
        $srcImage = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ).$slider->getFilename();

        return '<image width="150" height="50" src ="'.$srcImage.'" alt="'.$slider->getFilename().'" title="'.$slider->getName().'" >';
    }
}
