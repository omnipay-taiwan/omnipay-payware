<?php

namespace Omnipay\Payware\Traits;

trait HasBooking
{
    /**
     * @param  string  $bookingId
     * @return self
     */
    public function setBookingId($bookingId)
    {
        return $this->setTransactionReference($bookingId);
    }

    /**
     * @return string
     */
    public function getBookingId()
    {
        return $this->getTransactionReference();
    }

    /**
     * @param  string  $custOrderNo
     * @return self
     */
    public function setCustOrderNo($custOrderNo)
    {
        return $this->setTransactionId($custOrderNo);
    }

    /**
     * @return string
     */
    public function getCustOrderNo()
    {
        return $this->getTransactionId();
    }

    /**
     * @param  string  $sendType
     * @return self
     */
    public function setSendType($sendType)
    {
        return $this->setParameter('SendType', $sendType);
    }

    /**
     * @return string
     */
    public function getSendType()
    {
        return $this->getParameter('SendType');
    }
}
