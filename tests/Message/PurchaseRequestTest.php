<?php

namespace Omnipay\Payware\Tests\Message;

use Omnipay\Payware\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function testGetData()
    {
        $parameters = [
            'MerchantId' => 1,
            'TerminalId' => 101,
            'MerchantName' => '',
            'Amount' => 162,
            'OrderNo' => '6636797108956306177',
            'ReturnURL' => 'http://localhost/return.php',
            'ReceiveURL' => 'http://localhost/receive.php',
            'OrderDesc' => 'products',
            'PayType' => 1,
            'ValidateKey' => 'validateKey',
            'CardHolder' => 'tester',
            'Mobile' => '09123456',
            'TelNumber' => '07-xxxx',
            'Email' => 'test@test.com',
            'Address' => '高雄市**區',
            'MemberId' => '',
            'DeadlineDate' => '',
            'DeadlineTime' => '',
        ];
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge($parameters, [
            'Domain' => 'awsgamer.net',
        ]));

        $this->assertEquals($parameters, $request->getData());

        return [$request->send(), $parameters];
    }

    /**
     * @depends testGetData
     * @param array $results
     */
    public function testSend($results)
    {
        list($response, $parameters) = $results;

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('POST', $response->getRedirectMethod());
        $this->assertEquals('https://www.awsgamer.net/authpay', $response->getRedirectUrl());
        $this->assertEquals($parameters, $response->getRedirectData());
    }
}
