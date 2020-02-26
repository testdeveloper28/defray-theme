<?php
/**
 * @author Dotsquares Team
 * @copyright Copyright (c) 2015 Dotsquares (http://www.dotsquares.com)
 * @package Dotsquares_Quickview
 */

namespace Dotsquares\Quickview\Controller\Index;

class Updatecart extends \Magento\Framework\App\Action\Action
{
    protected $resultJsonFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\UrlFactory $urlFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            $this->_redirect('/');
            return;
        }
        $result = ['result' => true];
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($result);
    }
}