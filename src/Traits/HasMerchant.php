<?php

namespace Omnipay\Payware\Traits;

use Omnipay\Payware\Message\PurchaseRequest;

trait HasMerchant
{
    /**
     * @return self
     */
    public function setEndpoint($endpoint)
    {
        return $this->setParameter('endpoint', $endpoint);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->getParameter('endpoint');
    }

    /**
     * @param  string  $merchantId
     * @return self
     */
    public function setMerchantId($merchantId)
    {
        return $this->setParameter('MerchantId', $merchantId);
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->getParameter('MerchantId');
    }

    /**
     * @param  string  $terminalId
     * @return self
     */
    public function setTerminalId($terminalId)
    {
        return $this->setParameter('TerminalId', $terminalId);
    }

    /**
     * @return string
     */
    public function getTerminalId()
    {
        return $this->getParameter('TerminalId');
    }

    /**
     * @param  string  $merchantName
     * @return self
     */
    public function setMerchantName($merchantName)
    {
        return $this->setParameter('MerchantName', $merchantName);
    }

    /**
     * @return string
     */
    public function getMerchantName()
    {
        return $this->getParameter('MerchantName');
    }

    /**
     * @param  string  $validateKey
     * @return PurchaseRequest
     */
    public function setValidateKey($validateKey)
    {
        return $this->setParameter('ValidateKey', $validateKey);
    }

    /**
     * @return string
     */
    public function getValidateKey()
    {
        return $this->getParameter('ValidateKey');
    }

    /**
     * 1：信用卡、2：虛擬帳號、3：超商條碼、4：7-11Ibon(代碼)、5：ATM、6：FamiPort(代碼)。
     *
     * @param  string  $payType
     * @return PurchaseRequest
     */
    public function setPayType($payType)
    {
        return $this->setPaymentMethod($payType);
    }

    /**
     * @return string
     */
    public function getPayType()
    {
        return $this->getPaymentMethod();
    }
}
