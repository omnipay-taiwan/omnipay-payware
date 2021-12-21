<?php

namespace Omnipay\Payware\Traits;

trait HasBooking
{
    /**
     * @param string $bookingId
     * @return $this
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
     * @param string $custOrderNo
     * @return $this
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
     * @param string $sendType
     * @return $this
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
