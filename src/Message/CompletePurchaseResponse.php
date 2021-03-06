<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->valid() && $this->getCode() === '000';
    }

    /**
     * Response Message.
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage()
    {
        return $this->data['RtnMsg'];
    }

    /**
     * Response code.
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode()
    {
        return $this->data['RtnCode'];
    }

    /**
     * Gateway Reference.
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        return $this->data['BookingId'];
    }

    /**
     * Get the transaction ID as generated by the merchant website.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->data['CustOrderNo'];
    }

    protected function valid()
    {
        return hash_equals($this->request->getCheckMacValue(), $this->makeHash());
    }

    /**
     * @return string
     */
    private function makeHash()
    {
        $keys = ['MerchantId', 'TerminalId', 'PayType', 'BookingId', 'CustOrderNo', 'Amount', 'RtnCode'];
        $values = array_reduce($keys, function ($acc, $key) {
            return $acc.$this->data[$key];
        }, '');

        return hash_hmac('sha1', $values, $this->request->getValidateKey());
    }
}
