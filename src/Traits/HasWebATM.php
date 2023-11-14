<?php

namespace Omnipay\Payware\Traits;

trait HasWebATM
{
    /**
     * @param  string  $bankCode
     * @return self
     */
    public function setBankCode($bankCode)
    {
        return $this->setParameter('BankCode', $bankCode);
    }

    /**
     * @return string
     */
    public function getBankCode()
    {
        return $this->getParameter('BankCode');
    }

    /**
     * @param  string  $atmNo
     * @return self
     */
    public function setAtmNo($atmNo)
    {
        return $this->setParameter('AtmNo', $atmNo);
    }

    /**
     * @return string
     */
    public function getAtmNo()
    {
        return $this->getParameter('AtmNo');
    }
}
