<?php

namespace Omnipay\Payware\Traits;

use Omnipay\Payware\Message\PurchaseRequest;

trait HasMerchant
{
    /**
     * @param string $merchantId
     * @return $this
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
     * @param string $terminalId
     * @return $this
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
     * @param string $merchantName
     * @return $this
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
     * @param string $validateKey
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
}
