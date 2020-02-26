<?php


namespace Dotsquares\Brand\Model;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
	
   
	public function toOptionArray()
    {
        return [
            self::STATUS_ENABLED => __('Enabled')
            , self::STATUS_DISABLED => __('Disabled'),
        ];
    }
}
