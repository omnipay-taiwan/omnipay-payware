<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Message\ResponseInterface;

class GetPaymentInfoRequest extends AbstractRequest
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
        return $this->response = new GetPaymentInfoResponse($this, $data);
    }
}
