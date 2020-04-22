<?php

namespace Omnipay\Payware\Tests\Message;

use Omnipay\Payware\Message\ReceiveTransactionRequest;
use Omnipay\Tests\TestCase;

class ReceiveTransactionRequestTest extends TestCase
{
    public function testAtmNoGetData()
    {
        /**
         * 'MerchantId' => 'test001',
         * 'TerminalId' => 'test001001',
         * 'PayType' => '4',
         * 'BookingId' => 'PW420042200560',
         * 'CustOrderNo' => 'a82f2c7311c37f07c75aa6283fb182ce',
         * 'Amount' => '200',
         * 'PaymentNo' => 'CCAT011404971656',
         * 'PayEndDate' => '2020-04-23',
         * 'SendType' => '1',.
         */
        $parameters = [
            'MerchantId' => 'test001',
            'TerminalId' => 'test001001',
            'PayType' => '2',
            'Amount' => '200',
            'BookingId' => 'PW220021272913',
            'CustOrderNo' => '62691cdf-38ef-4ca3-98ea-da3532215ef1',
            'SendType' => '1',
            'BankCode' => '050',
            'AtmNo' => '2592600213085401',
            'PayEndDate' => '2020/02/13 23:59:59',
        ];
        $request = new ReceiveTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($parameters);

        $this->assertEquals(array_merge($parameters, [
            'PayEndDate' => '2020-02-13 23:59:59',
        ]), $request->getData());

        return [$request->send(), $parameters];
    }

    /**
     * @depends testAtmNoGetData
     * @param array $results
     */
    public function testAtmSend($results)
    {
        list($response, $parameters) = $results;

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($parameters['AtmNo'], $response->getData()['AtmNo']);
    }

    public function testPaymentNoGetData()
    {
        $parameters = [
            'MerchantId' => 'test001',
            'TerminalId' => 'test001001',
            'PayType' => '4',
            'BookingId' => 'PW420042200560',
            'CustOrderNo' => 'a82f2c7311c37f07c75aa6283fb182ce',
            'Amount' => '200',
            'PaymentNo' => 'CCAT011404971656',
            'PayEndDate' => '2020-04-23',
            'SendType' => '1',
        ];
        $request = new ReceiveTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($parameters);

        $this->assertEquals($parameters, $request->getData());

        return [$request->send(), $parameters];
    }

    /**
     * @depends testPaymentNoGetData
     * @param array $results
     */
    public function testPaymentNoSend($results)
    {
        list($response, $parameters) = $results;

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($parameters['PaymentNo'], $response->getData()['PaymentNo']);
    }
}
