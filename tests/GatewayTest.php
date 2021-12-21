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
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
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
        $options = [
            'SendType' => 2,
            'transactionReference' => 'abc123',
        ];
        $request = $this->gateway->completePurchase($options);

        self::assertInstanceOf(CompletePurchaseRequest::class, $request);
        self::assertArrayHasKey('BookingId', $request->getData());
    }

    public function testAccessNotification()
    {
        $options = [
            'SendType' => 1,
            'transactionReference' => 'abc123',
        ];
        $request = $this->gateway->completePurchase($options);

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
