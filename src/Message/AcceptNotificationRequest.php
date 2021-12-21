<?php

namespace Omnipay\Payware\Message;

class AcceptNotificationRequest extends CompletePurchaseRequest
{
    /**
     * @param mixed $data
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new AcceptNotificationResponse($this, $data);
    }
}
