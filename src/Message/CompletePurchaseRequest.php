<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Payware\Support\Helper;
use Omnipay\Payware\Traits\HasAmount;
use Omnipay\Payware\Traits\HasBooking;
use Omnipay\Payware\Traits\HasCreditCard;
use Omnipay\Payware\Traits\HasCVS;
use Omnipay\Payware\Traits\HasMerchant;

class CompletePurchaseRequest extends AbstractRequest
{
    use HasMerchant;
    use HasBooking;
    use HasCreditCard;
    use HasCVS;
    use HasAmount;

    /**
     * @param  int  $authAmount
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
     * @param  string  $rtnCode
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
     * @param  string  $rtnMsg
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
     * @param  string  $paymentDate
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
     * @return CompletePurchaseRequest
     */
    public function setTransferOutAccount($transferOutAccount)
    {
        return $this->setParameter('TransferOutAccount', $transferOutAccount);
    }

    /**
     * @return string
     */
    public function getTransferOutAccount()
    {
        return $this->getParameter('TransferOutAccount');
    }

    /**
     * @param  string  $checkMacValue
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
     * @throws InvalidRequestException
     * @throws InvalidResponseException
     */
    public function getData()
    {
        return $this->checkMacValue(Helper::filterEmpty([
            'MerchantId' => $this->getMerchantId(),
            'TerminalId' => $this->getTerminalId(),
            'PayType' => $this->getPayType(),
            'BookingId' => $this->getTransactionReference(),
            'CustOrderNo' => $this->getTransactionId(),
            'Amount' => $this->getAmount(),
            'AuthAmount' => $this->getAuthAmount(),
            'RtnCode' => $this->getRtnCode(),
            'Card4no' => $this->getCard4No(),
            'Payment_no' => $this->getPaymentNo(),
            'RtnMsg' => $this->getRtnMsg(),
            'PaymentDate' => Helper::parseDate($this->getPaymentDate()),
            'TransferOutAccount' => $this->getTransferOutAccount(),
            'SendType' => $this->getSendType(),
            'CheckMacValue' => $this->getCheckMacValue(),
        ]));
    }

    /**
     * @param  mixed  $data
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    /**
     * @return array
     *
     * @throws InvalidResponseException
     */
    private function checkMacValue($data)
    {
        $checkMacValue = $this->getCheckMacValue();
        if (! $checkMacValue || ! hash_equals($checkMacValue, $this->makeHash($data))) {
            throw new InvalidResponseException();
        }

        return $data;
    }

    /**
     * @return false|string
     */
    private function makeHash($data)
    {
        $keys = ['MerchantId', 'TerminalId', 'PayType', 'BookingId', 'CustOrderNo', 'Amount', 'RtnCode'];
        $values = array_reduce($keys, static function ($acc, $key) use ($data) {
            return $acc.(array_key_exists($key, $data) ? $data[$key] : '');
        }, '');

        return hash_hmac('sha1', $values, $this->getValidateKey());
    }
}
