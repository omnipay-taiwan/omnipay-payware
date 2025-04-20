<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Payware\Traits\HasMerchant;

class CompletePurchaseRequest extends AbstractRequest
{
    use HasMerchant;

    /**
     * @throws InvalidResponseException
     */
    public function getData()
    {
        return $this->checkMacValue($this->httpRequest->request->all());
    }

    /**
     * @param  mixed  $data
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    /**
     * @return array
     *
     * @throws InvalidRequestException
     */
    private function checkMacValue($data)
    {
        if (! hash_equals($this->makeHash($data), $this->httpRequest->request->get('CheckMacValue', ''))) {
            throw new InvalidRequestException('Incorrect CheckMacValue');
        }

        return $data;
    }

    /**
     * @return string
     */
    private function makeHash($data)
    {
        $keys = ['MerchantId', 'TerminalId', 'PayType', 'BookingId', 'CustOrderNo', 'Amount', 'RtnCode'];
        $values = array_reduce($keys, static function ($acc, $key) use ($data) {
            return $acc.(array_key_exists($key, $data) ? $data[$key] : '');
        }, '');

        return hash_hmac('sha1', $values, $this->getValidateKey());
    }
}
