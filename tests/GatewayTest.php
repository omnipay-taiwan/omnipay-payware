<?php

namespace Omnipay\Payware\Tests;

use Omnipay\Payware\Gateway;
use Omnipay\Payware\Message\CompletePurchaseRequest;
use Omnipay\Payware\Message\PurchaseRequest;
use Omnipay\Payware\Message\ReceiveRequest;
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

        $this->assertInstanceOf(PurchaseRequest::class, $request);
        $this->assertArrayHasKey('Amount', $request->getData());
    }

    public function testCompletePurchase()
    {
        $options = ['transactionReference' => 'abc123'];
        $request = $this->gateway->completePurchase($options);

        $this->assertInstanceOf(CompletePurchaseRequest::class, $request);
        $this->assertArrayHasKey('BookingId', $request->getData());
    }

    public function testReceiveTransaction()
    {
        $options = [];
        $request = $this->gateway->receive($options);

        $this->assertInstanceOf(ReceiveRequest::class, $request);
    }
}
