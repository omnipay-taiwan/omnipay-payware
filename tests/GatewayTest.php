<?php

namespace Omnipay\Payware\Tests;

use Omnipay\Payware\Gateway;
use Omnipay\Payware\Message\AcceptNotificationRequest;
use Omnipay\Payware\Message\CompletePurchaseRequest;
use Omnipay\Payware\Message\PurchaseRequest;
use Omnipay\Payware\Message\ReceiveTransactionInfoRequest;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize(['ValidateKey' => 'validateKey']);
    }

    public function testPurchase()
    {
        $options = ['OrderNo' => 'abc', 'amount' => '10.00'];
        $request = $this->gateway->purchase($options);

        self::assertInstanceOf(PurchaseRequest::class, $request);
        self::assertArrayHasKey('Amount', $request->getData());
    }

    public function testCompletePurchase()
    {
        $data = [
            'MerchantId' => '1',
            'TerminalId' => '101',
            'PayType' => '1',
            'BookingId' => 'PW118120600018',
            'CustOrderNo' => '6636797108956306177',
            'Amount' => '162',
            'RtnCode' => '000',
            'CheckMacValue' => '921789856e652959fdc6439cfb23068a4066902b',
            'AuthAmount' => '162',
            'RtnMsg' => '授權成功。',
            'PaymentDate' => '2019/08/08',
            'SendType' => '1',
            'Card4no' => '1111',
        ];
        $this->getHttpRequest()->request->add($data);
        $request = $this->gateway->completePurchase();

        self::assertInstanceOf(CompletePurchaseRequest::class, $request);
        self::assertArrayHasKey('BookingId', $request->getData());
    }

    public function testAccessNotification()
    {
        $data = [
            'MerchantId' => '1',
            'TerminalId' => '101',
            'PayType' => '1',
            'BookingId' => 'PW118120600018',
            'CustOrderNo' => '6636797108956306177',
            'Amount' => '162',
            'RtnCode' => '000',
            'CheckMacValue' => '921789856e652959fdc6439cfb23068a4066902b',
            'AuthAmount' => '162',
            'RtnMsg' => '授權成功。',
            'PaymentDate' => '2019/08/08',
            'SendType' => '1',
            'Card4no' => '1111',
        ];
        $this->getHttpRequest()->request->add($data);
        $request = $this->gateway->completePurchase();

        self::assertInstanceOf(AcceptNotificationRequest::class, $request);
        self::assertArrayHasKey('BookingId', $request->getData());
    }

    public function testReceiveTransactionInfo()
    {
        $options = [];
        $request = $this->gateway->receiveTransactionInfo($options);

        self::assertInstanceOf(ReceiveTransactionInfoRequest::class, $request);
    }
}
