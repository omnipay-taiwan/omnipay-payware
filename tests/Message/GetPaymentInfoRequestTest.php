<?php

namespace Omnipay\Payware\Tests\Message;

use Omnipay\Payware\Message\GetPaymentInfoRequest;
use Omnipay\Tests\TestCase;

class GetPaymentInfoRequestTest extends TestCase
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
        $data = [
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
        $this->getHttpRequest()->request->add($data);
        $request = new GetPaymentInfoRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize();

        self::assertEquals(array_merge($data, ['PayEndDate' => '2020/02/13 23:59:59']), $request->getData());

        return [$request->send(), $data];
    }

    /**
     * @depends testAtmNoGetData
     *
     * @param  array  $results
     */
    public function testAtmSend($results)
    {
        [$response, $options] = $results;

        self::assertFalse($response->isSuccessful());
        self::assertEquals($options['AtmNo'], $response->getData()['AtmNo']);
        self::assertEquals('OK', $response->getReply());
    }

    public function testPaymentNoGetData()
    {
        $data = [
            'MerchantId' => 'test001',
            'TerminalId' => 'test001001',
            'PayType' => '4',
            'BookingId' => 'PW420042200560',
            'CustOrderNo' => 'a82f2c7311c37f07c75aa6283fb182ce',
            'Amount' => '200',
            'Barcode1~3' => 'barcode',
            'PaymentNo' => 'CCAT011404971656',
            'PayEndDate' => '2020-04-23',
            'SendType' => '1',
        ];
        $this->getHttpRequest()->request->add($data);
        $request = new GetPaymentInfoRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize();

        self::assertEquals($data, $request->getData());

        return [$request->send(), $data];
    }

    /**
     * @depends testPaymentNoGetData
     *
     * @param  array  $results
     */
    public function testPaymentNoSend($results)
    {
        [$response, $options] = $results;

        self::assertFalse($response->isSuccessful());
        self::assertEquals($options['PaymentNo'], $response->getData()['PaymentNo']);
        self::assertEquals('OK', $response->getReply());
    }
}
