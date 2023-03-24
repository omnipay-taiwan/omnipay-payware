<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Payware\Support\Helper;
use Omnipay\Payware\Traits\HasAmount;
use Omnipay\Payware\Traits\HasBooking;
use Omnipay\Payware\Traits\HasCVS;
use Omnipay\Payware\Traits\HasMerchant;
use Omnipay\Payware\Traits\HasWebATM;

class ReceiveTransactionInfoRequest extends AbstractRequest
{
    use HasMerchant;
    use HasBooking;
    use HasWebATM;
    use HasCVS;
    use HasAmount;

    /**
     * @param  string  $payEndDate
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
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        return Helper::filterEmpty([
            'MerchantId' => $this->getMerchantId(),
            'TerminalId' => $this->getTerminalId(),
            'PayType' => $this->getPayType(),
            'Amount' => $this->getAmount(),
            'BookingId' => $this->getBookingId(),
            'CustOrderNo' => $this->getTransactionId(),
            'SendType' => $this->getSendType(),
            'BankCode' => $this->getBankCode(),
            'AtmNo' => $this->getAtmNo(),
            'PayEndDate' => Helper::parseDate($this->getPayEndDate()),
            'Barcode1~3' => $this->getBarcode1_3(),
            'PaymentNo' => $this->getPaymentNo(),
        ]);
    }

    /**
     * @param  mixed  $data
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new ReceiveTransactionInfoResponse($this, $data);
    }
}
