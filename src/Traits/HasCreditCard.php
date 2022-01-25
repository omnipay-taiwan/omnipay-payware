<?php

namespace Omnipay\Payware\Traits;

trait HasCreditCard
{
    /**
     * @param string $card4No
     * @return $this
     */
    public function setCard4No($card4No)
    {
        return $this->setParameter('Card4No', $card4No);
    }

    /**
     * @return string
     */
    public function getCard4No()
    {
        return $this->getParameter('Card4No');
    }
}
