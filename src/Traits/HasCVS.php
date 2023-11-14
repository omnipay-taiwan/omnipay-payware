<?php

namespace Omnipay\Payware\Traits;

trait HasCVS
{
    /**
     * @param  string  $barcode
     * @return self
     */
    public function setBarcode1_3($barcode)
    {
        return $this->setParameter('Barcode1~3', $barcode);
    }

    /**
     * @return string
     */
    public function getBarcode1_3()
    {
        return $this->getParameter('Barcode1~3');
    }

    /**
     * @param  string  $paymentNo
     * @return self
     */
    public function setPaymentNo($paymentNo)
    {
        return $this->setParameter('PaymentNo', $paymentNo);
    }

    /**
     * @return string
     */
    public function getPaymentNo()
    {
        return $this->getParameter('PaymentNo');
    }
}
