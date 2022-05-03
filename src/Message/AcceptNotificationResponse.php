<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Message\NotificationInterface;

class AcceptNotificationResponse extends CompletePurchaseResponse implements NotificationInterface
{
    public function getReply()
    {
        return $this->isSuccessful() ? 'OK' : 'FAIL';
    }

    public function getTransactionStatus()
    {
        return $this->isSuccessful() ? self::STATUS_COMPLETED : self::STATUS_FAILED;
    }
}
