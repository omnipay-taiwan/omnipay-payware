<?php

namespace Omnipay\Payware\Tests\Message;

use Omnipay\Payware\Message\ReceiveTransactionInfoRequest;
use Omnipay\Tests\TestCase;

class ReceiveTransactionInfoRequestTest extends TestCase
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
        $options = [
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
        $request = new ReceiveTransactionInfoRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($options);

        self::assertEquals(array_merge($options, [
            'PayEndDate' => '2020-02-13 23:59:59',
        ]), $request->getData());

        return [$request->send(), $options];
    }

    /**
     * @depends testAtmNoGetData
     * @param array $results
     */
    public function testAtmSend($results)
    {
        list($response, $options) = $results;

        self::assertTrue($response->isSuccessful());
        self::assertEquals($options['AtmNo'], $response->getData()['AtmNo']);
        self::assertEquals('OK', $response->getMessage());
    }

    public function testPaymentNoGetData()
    {
        $options = [
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
        $request = new ReceiveTransactionInfoRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($options);

        self::assertEquals($options, $request->getData());

        return [$request->send(), $options];
    }

    /**
     * @depends testPaymentNoGetData
     * @param array $results
     */
    public function testPaymentNoSend($results)
    {
        list($response, $options) = $results;

        self::assertTrue($response->isSuccessful());
        self::assertEquals($options['PaymentNo'], $response->getData()['PaymentNo']);
        self::assertEquals('OK', $response->getMessage());
    }
}
