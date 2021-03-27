<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Payware\Support\Helper;
use Omnipay\Payware\Traits\HasBooking;
use Omnipay\Payware\Traits\HasMerchant;

class ReceiveTransactionInfoRequest extends AbstractRequest
{
    use HasMerchant;
    use HasBooking;

    /**
     * @param string $bankCode
     * @return ReceiveTransactionInfoRequest
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
     * @param string $atmNo
     * @return ReceiveTransactionInfoRequest
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

    /**
     * @param string $paymentNo
     * @return ReceiveTransactionInfoRequest
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

    /**
     * @param string $payEndDate
     * @return ReceiveTransactionInfoRequest
     */
    public function setPayEndDate($payEndDate)
    {
        return $this->setParameter('PayEndDate', $payEndDate);
    }

    /**
     * @return string
     */
    public function getPayEndDate()
    {
        return $this->getParameter('PayEndDate');
    }

    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        return array_filter([
            'MerchantId' => $this->getMerchantId(),
            'TerminalId' => $this->getTerminalId(),
            'PayType' => $this->getPayType(),
            'Amount' => (int) $this->getAmount(),
            'BookingId' => $this->getBookingId(),
            'CustOrderNo' => $this->getTransactionId(),
            'SendType' => $this->getSendType(),
            'BankCode' => $this->getBankCode(),
            'AtmNo' => $this->getAtmNo(),
            'PaymentNo' => $this->getPaymentNo(),
            'PayEndDate' => Helper::parseDate($this->getPayEndDate()),
        ], function ($value) {
            return ! empty($value);
        });
    }

    /**
     * @param mixed $data
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new ReceiveTransactionInfoResponse($this, $data);
    }
}
