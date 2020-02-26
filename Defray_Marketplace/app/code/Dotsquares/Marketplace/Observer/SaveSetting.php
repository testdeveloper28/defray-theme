<?php

namespace Dotsquares\Marketplace\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveSetting implements ObserverInterface
{
    protected $_messageManager;
    
	/**
     * @param \Magento\Backend\Helper\Data $backendData
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\App\ResponseInterface $response
     */
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
		\Dotsquares\Marketplace\Helper\Data $helper,
		\Magento\Cms\Model\BlockFactory $blockFactory
    ) {
        $this->_messageManager = $messageManager;
        $this->_helper = $helper;
        $this->_blockFactory = $blockFactory;
    }

    /**
     * Log out user and redirect to new admin custom url
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
		$this->checkBlock('setting', $observer->getData("website"), $observer->getData("store"));
    }
	
    public function checkBlock()
    {
		$blocks_lists = array();
		$config_value = $this->_helper->getConfig('marketplace_settings');
		$blocks_lists[] = $config_value['header']['header_social_block'];
		$blocks_lists[] = 'testttt';
		foreach($blocks_lists as $blocks_list){
			try{
		        $blockisActive = $this->_blockFactory->create()->load($blocks_list, 'identifier')->getIsActive();
			    if ($blockisActive != 1){
			       echo 'sry</br>';
			    }
		    } catch (\Exception $e) {
                $this->messageManager->addException($e, __('We can\'t delete your account.'));
            }
		}
    }
}
