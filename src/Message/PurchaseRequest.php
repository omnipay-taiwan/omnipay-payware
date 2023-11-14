<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Payware\Support\Helper;
use Omnipay\Payware\Traits\HasAmount;
use Omnipay\Payware\Traits\HasMerchant;
use Omnipay\Payware\Traits\HasPaymentInfo;

class PurchaseRequest extends AbstractRequest
{
    use HasMerchant;
    use HasAmount;
    use HasPaymentInfo;

    /**
     * @param  string  $orderNo
     * @return PurchaseRequest
     */
    public function setOrderNo($orderNo)
    {
        return $this->setTransactionId($orderNo);
    }

    /**
     * @return string
     */
    public function getOrderNo()
    {
        return $this->getTransactionId();
    }

    /**
     * @param  string  $value
     * @return PurchaseRequest
     */
    public function setReceiveUrl($value)
    {
        return $this->setPaymentInfoUrl($value);
    }

    /**
     * @return string
     */
    public function getReceiveUrl()
    {
        return $this->getPaymentInfoUrl();
    }

    /**
     * @param  string  $orderDesc
     * @return PurchaseRequest
     */
    public function setOrderDesc($orderDesc)
    {
        return $this->setDescription($orderDesc);
    }

    /**
     * @return string
     */
    public function getOrderDesc()
    {
        return $this->getDescription();
    }

    /**
     * @param  string  $cardHolder
     * @return PurchaseRequest
     */
    public function setCardHolder($cardHolder)
    {
        return $this->setParameter('CardHolder', $cardHolder);
    }

    /**
     * @return string
     */
    public function getCardHolder()
    {
        return $this->getParameter('CardHolder');
    }

    /**
     * @param  string  $mobile
     * @return PurchaseRequest
     */
    public function setMobile($mobile)
    {
        return $this->setParameter('Mobile', $mobile);
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->getParameter('Mobile');
    }

    /**
     * @param  string  $telNumber
     * @return PurchaseRequest
     */
    public function setTelNumber($telNumber)
    {
        return $this->setParameter('TelNumber', $telNumber);
    }

    /**
     * @return string
     */
    public function getTelNumber()
    {
        return $this->getParameter('TelNumber');
    }

    /**
     * @param  string  $email
     * @return PurchaseRequest
     */
    public function setEmail($email)
    {
        return $this->setParameter('Email', $email);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->getParameter('Email');
    }

    /**
     * @param  string  $address
     * @return PurchaseRequest
     */
    public function setAddress($address)
    {
        return $this->setParameter('Address', $address);
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->getParameter('Address');
    }

    /**
     * @param  string  $memberId
     * @return PurchaseRequest
     */
    public function setMemberId($memberId)
    {
        return $this->setParameter('MemberId', $memberId);
    }

    /**
     * @return string
     */
    public function getMemberId()
    {
        return $this->getParameter('MemberId');
    }

    /**
     * 超商及虛擬帳號繳款截止日。
     * 例如：2018/10/5 且不得大於七日
     * 如無資料時以七天為預設值
     * Ibon、Famiport目前最大值為7天
     * ※僅限付款方式為2.3.4.6。
     *
     * @param  string  $deadlineDate
     * @return PurchaseRequest
     */
    public function setDeadlineDate($deadlineDate)
    {
        return $this->setParameter('DeadlineDate', $deadlineDate);
    }

    /**
     * 超商及虛擬帳號繳款截止時間※僅限付款方式為2.3.4.6。
     *
     * @return string
     */
    public function getDeadlineDate()
    {
        return $this->getParameter('DeadlineDate');
    }

    /**
     * @param  string  $deadlineTime
     * @return PurchaseRequest
     */
    public function setDeadlineTime($deadlineTime)
    {
        return $this->setParameter('DeadlineTime', $deadlineTime);
    }

    /**
     * @return string
     */
    public function getDeadlineTime()
    {
        return $this->getParameter('DeadlineTime');
    }

    /**
     * @param  string  $deadlineTime
     * @return PurchaseRequest
     */
    public function setUSN($deadlineTime)
    {
        return $this->setParameter('USN', $deadlineTime);
    }

    /**
     * @return string
     */
    public function getUSN()
    {
        return $this->getParameter('USN');
    }

    /**
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('endpoint', 'MerchantId', 'TerminalId', 'amount', 'transactionId');

        return [
            'MerchantId' => $this->getMerchantId(),
            'TerminalId' => $this->getTerminalId(),
            'MerchantName' => $this->getMerchantName(),
            'Amount' => $this->getAmount(),
            'OrderNo' => $this->getTransactionId(),
            'ReturnURL' => $this->getReturnUrl(),
            'ReceiveURL' => $this->getPaymentInfoUrl(),
            'OrderDesc' => $this->getDescription(),
            'PayType' => $this->getPayType() ?: 1,
            'ValidateKey' => $this->getValidateKey(),
            'CardHolder' => $this->getCardHolder(),
            'Mobile' => $this->getMobile(),
            'TelNumber' => $this->getTelNumber(),
            'Email' => $this->getEmail(),
            'Address' => $this->getAddress(),
            'MemberId' => $this->getMemberId(),
            'DeadlineDate' => Helper::parseDate($this->getDeadlineDate(), 'Y/m/d'),
            'DeadlineTime' => Helper::parseDate($this->getDeadlineTime(), 'H:i:s'),
            'USN' => $this->getUSN(),
        ];
    }

    /**
     * @param  array  $data
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
