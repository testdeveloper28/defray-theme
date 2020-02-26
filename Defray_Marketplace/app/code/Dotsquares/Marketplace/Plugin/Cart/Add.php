<?php
namespace Dotsquares\Marketplace\Plugin\Cart;

use Magento\Framework\App\ObjectManager;

class Add {

  public function afterExecute(\Magento\Checkout\Controller\Cart\Add $subject, $result) {
    $subject->getResponse()->representJson(
        $objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($result1)
    );
    return $result;
  }
}