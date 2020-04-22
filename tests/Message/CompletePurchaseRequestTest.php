<?php

namespace Omnipay\Payware\Tests\Message;

use Omnipay\Payware\Message\CompletePurchaseRequest;
use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
    public function testGetData()
    {
        $parameters = [
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
        ];
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge($parameters, [
            'ValidateKey' => 'validateKey',
        ]));

        $this->assertEquals(array_merge($parameters, [
            'PaymentDate' => '2019-08-08'
        ]), $request->getData());

        return [$request->send()];
    }

    /**
     * @depends testGetData
     * @param array $parameters
     */
    public function testSend($parameters)
    {
        list($response) = $parameters;

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('000', $response->getCode());
        $this->assertEquals('授權成功。', $response->getMessage());
        $this->assertEquals('6636797108956306177', $response->getTransactionId());
        $this->assertEquals('PW118120600018', $response->getTransactionReference());
    }
}
