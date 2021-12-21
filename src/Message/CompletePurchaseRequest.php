<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Payware\Support\Helper;
use Omnipay\Payware\Traits\HasBooking;
use Omnipay\Payware\Traits\HasMerchant;

class CompletePurchaseRequest extends AbstractRequest implements NotificationInterface
{
    use HasMerchant;
    use HasBooking;

    /**
     * @param int $authAmount
     * @return CompletePurchaseRequest
     */
    public function setAuthAmount($authAmount)
    {
        return $this->setParameter('AuthAmount', $authAmount);
    }

    /**
     * @return int
     */
    public function getAuthAmount()
    {
        return $this->getParameter('AuthAmount');
    }

    /**
     * @param string $rtnCode
     * @return CompletePurchaseRequest
     */
    public function setRtnCode($rtnCode)
    {
        return $this->setParameter('RtnCode', $rtnCode);
    }

    /**
     * @return string
     */
    public function getRtnCode()
    {
        return $this->getParameter('RtnCode');
    }

    /**
     * @param string $rtnMsg
     * @return CompletePurchaseRequest
     */
    public function setRtnMsg($rtnMsg)
    {
        return $this->setParameter('RtnMsg', $rtnMsg);
    }

    /**
     * @return string
     */
    public function getRtnMsg()
    {
        return $this->getParameter('RtnMsg');
    }

    /**
     * @param string $paymentDate
     * @return CompletePurchaseRequest
     */
    public function setPaymentDate($paymentDate)
    {
        return $this->setParameter('PaymentDate', $paymentDate);
    }

    /**
     * @return string
     */
    public function getPaymentDate()
    {
        return $this->getParameter('PaymentDate');
    }

    /**
     * @param string $checkMacValue
     * @return CompletePurchaseRequest
     */
    public function setCheckMacValue($checkMacValue)
    {
        return $this->setParameter('CheckMacValue', $checkMacValue);
    }

    /**
     * @return string
     */
    public function getCheckMacValue()
    {
        return $this->getParameter('CheckMacValue');
    }

    public function getData()
    {
        return [
            'MerchantId' => $this->getMerchantId(),
            'TerminalId' => $this->getTerminalId(),
            'PayType' => $this->getPayType(),
            'Amount' => (int) $this->getAmount(),
            'AuthAmount' => (int) $this->getAuthAmount(),
            'BookingId' => $this->getTransactionReference(),
            'CustOrderNo' => $this->getTransactionId(),
            'RtnCode' => $this->getRtnCode(),
            'RtnMsg' => $this->getRtnMsg(),
            'PaymentDate' => Helper::parseDate($this->getPaymentDate()),
            'CheckMacValue' => $this->getCheckMacValue(),
            'SendType' => $this->getSendType(),
        ];
    }

    /**
     * @param mixed $data
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    public function getTransactionStatus()
    {
        return $this->getNotification()->getTransactionStatus();
    }

    public function getMessage()
    {
        return $this->getNotification()->getMessage();
    }

    /**
     * @return NotificationInterface
     */
    private function getNotification()
    {
        return ! $this->response ? $this->send() : $this->response;
    }
}
