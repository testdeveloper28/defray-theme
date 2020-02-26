<?php
/**
 * @author Dotsquares Team
 * @copyright Copyright (c) 2015 Dotsquares (http://www.dotsquares.com)
 * @package Dotsquares_Quickview
 */

namespace Dotsquares\Quickview\Plugin;

class ResultPage
{
    public function beforeAddPageLayoutHandles(
        \Magento\Framework\View\Result\Page $subject,
        array $parameters = [],
        $defaultHandle = null)
    {

        $arrayKeys = array_keys($parameters);
        if ((count($arrayKeys) == 3) &&
                in_array('id', $arrayKeys) &&
                in_array('sku', $arrayKeys) &&
                in_array('type', $arrayKeys)) {

            return [$parameters, 'catalog_product_view'];
        }
    }

}
