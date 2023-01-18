<?php

namespace Omnipay\Payware\Traits;

trait HasWebATM
{
    /**
     * @param  string  $bankCode
     * @return $this
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
     * @return $this
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
