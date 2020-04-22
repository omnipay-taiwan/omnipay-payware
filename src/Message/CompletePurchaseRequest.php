<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Payware\Traits\HasDomain;
use Omnipay\Payware\Traits\HasMerchant;
use Omnipay\Payware\Traits\HasPayType;

class CompletePurchaseRequest extends AbstractRequest
{
    use HasDomain;
    use HasMerchant;
    use HasPayType;

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
     * @param string $bookingId
     * @return CompletePurchaseRequest
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
     * @return CompletePurchaseRequest
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

    /**
     * @param string $sendType
     * @return CompletePurchaseRequest
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
            'PaymentDate' => $this->getPaymentDate(),
            'CheckMacValue' => $this->getCheckMacValue(),
            'SendType' => $this->getSendType(),
        ];
    }

    /**
     * @param mixed $data
     * @return CompletePurchaseResponse
     * @throws InvalidRequestException
     */
    public function sendData($data)
    {
        if ($this->makeHash($data) !== $this->getCheckMacValue()) {
            throw new InvalidRequestException();
        }

        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    /**
     * @param array $data
     * @return string
     */
    private function makeHash($data)
    {
        $keys = ['MerchantId', 'TerminalId', 'PayType', 'BookingId', 'CustOrderNo', 'Amount', 'RtnCode'];
        $values = array_reduce($keys, function ($acc, $key) use ($data) {
            return $acc.$data[$key];
        }, '');

        return hash_hmac('sha1', $values, $this->getValidateKey());
    }
}
