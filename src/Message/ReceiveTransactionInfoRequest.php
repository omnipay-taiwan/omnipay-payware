<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Message\ResponseInterface;

class ReceiveTransactionInfoRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function getData()
    {
        return $this->httpRequest->request->all();
    }

    /**
     * @param  mixed  $data
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new ReceiveTransactionInfoResponse($this, $data);
    }
}
