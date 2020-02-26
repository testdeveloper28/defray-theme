<?php

namespace Dotsquares\Brand\Controller\Index;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Url;

class Router implements RouterInterface
{
    protected $actionFactory;
    protected $eventManager;
    protected $response;
    protected $dispatched;
    protected $_brandCollection;
    protected $_brandHelper;
    protected $storeManager;

    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        ManagerInterface $eventManager,
        \Dotsquares\Brand\Model\Brands $brandCollection,
        StoreManagerInterface $storeManager
    )
    {
        $this->actionFactory = $actionFactory;
        $this->eventManager = $eventManager;
        $this->response = $response;
        $this->_brandCollection = $brandCollection;
        $this->storeManager = $storeManager;
    }

    public function match(RequestInterface $request)
    {
		if (!$this->dispatched) {
            $urlKey = trim($request->getPathInfo(), '/');
			$origUrlKey = $urlKey;
            $condition = new DataObject(['url_key' => $urlKey, 'continue' => true]);
            $this->eventManager->dispatch(
                'dotsquares_brand_controller_router_match_before',
                ['router' => $this, 'condition' => $condition]
            );
            $urlKey = $condition->getUrlKey();
            if ($condition->getRedirectUrl()) {
                $this->response->setRedirect($condition->getRedirectUrl());
                $request->setDispatched(true);
                return $this->actionFactory->create(
                    'Magento\Framework\App\Action\Redirect',
                    ['request' => $request]
                );
            }
            if (!$condition->getContinue()) {
                return null;
            }
            $route = 'brand';
			if ($urlKey == $route) {
				$request->setModuleName('brand')
                    ->setControllerName('index')
                    ->setActionName('index');
                $request->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $urlKey);
                $this->dispatched = true;
                return $this->actionFactory->create(
                    'Magento\Framework\App\Action\Forward',
                    ['request' => $request]
                );
            }
			
            $identifiers = explode('/', $urlKey);
			if (count($identifiers) == 2 || count($identifiers) == 1) {
                if (count($identifiers) == 2) {
                    $brandUrl = $identifiers[1];
                }
                if (count($identifiers) == 1) {
                    $brandUrl = $identifiers[0];
                }
				$brandUrl = urldecode($brandUrl);
				$brand = $this->_brandCollection->getCollection()
                    ->addFieldToFilter('status', array('eq' => 1))
                    ->addFieldToFilter('optionlabel', array('eq' => $brandUrl))
                    ->getFirstItem();
				if ($brand && $brand->getId()) {
                    $request->setModuleName('brand')
                        ->setControllerName('brand')
                        ->setActionName('view')
                        ->setParam('brand_id', $brand->getId());
                    $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $origUrlKey);
                    $request->setDispatched(true);
                    $this->dispatched = true;
					return $this->actionFactory->create(
                        'Magento\Framework\App\Action\Forward',
                        ['request' => $request]
                    );
                }
            }
        }
    }
}