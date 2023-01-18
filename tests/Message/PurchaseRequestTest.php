<?php

namespace Omnipay\Payware\Tests\Message;

use Omnipay\Payware\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function testGetData()
    {
        $options = [
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
            'USN' => 'A123456789',
        ];
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge($options, [
            'endpoint' => 'www.foo.bar',
        ]));

        self::assertEquals($options, $request->getData());

        return [$request->send(), $options];
    }

    /**
     * @depends testGetData
     *
     * @param  array  $results
     */
    public function testSend($results)
    {
        [$response, $options] = $results;

        self::assertFalse($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertEquals('POST', $response->getRedirectMethod());
        self::assertEquals('https://www.foo.bar/authpay', $response->getRedirectUrl());
        self::assertEquals($options, $response->getRedirectData());
    }
}
