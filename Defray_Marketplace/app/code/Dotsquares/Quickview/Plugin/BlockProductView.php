<?php
/**
 * @author Dotsquares Team
 * @copyright Copyright (c) 2015 Dotsquares (http://www.dotsquares.com)
 * @package Dotsquares_Quickview
 */

namespace Dotsquares\Quickview\Plugin;

class BlockProductView
{
    protected $request;
    public function __construct(
            \Magento\Framework\App\Request\Http $request)
    {
        $this->request = $request;
    }

    public function afterShouldRenderQuantity(
        \Magento\Catalog\Block\Product\View $subject, $result)
    {
        return $result;
    }

}
