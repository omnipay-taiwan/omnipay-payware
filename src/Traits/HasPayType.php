<?php

namespace Omnipay\Payware\Traits;

use Omnipay\Payware\Message\PurchaseRequest;

trait HasPayType
{
    /**
     * 1：信用卡、2：虛擬帳號、3：超商條碼、4：7-11Ibon(代碼)、5：ATM、6：FamiPort(代碼)。
     *
     * @param string $payType
     * @return PurchaseRequest
     */
    public function setPayType($payType)
    {
        return $this->setParameter('PayType', $payType);
    }

    /**
     * @return string
     */
    public function getPayType()
    {
        return $this->getParameter('PayType');
    }
}
