<?php

namespace Omnipay\Payware\Tests\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Payware\Message\CompletePurchaseRequest;
use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
    public function testGetData()
    {
        $options = [
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
            'Payment_no' => '2222',
            'TransferOutAccount' => 'foo_account',
        ];
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge($options, [
            'ValidateKey' => 'validateKey',
        ]));

        self::assertEquals(array_merge($options, [
            'PaymentDate' => '2019-08-08',
        ]), $request->getData());

        return [$request->send()];
    }

    /**
     * @depends testGetData
     *
     * @param  array  $options
     */
    public function testSend($options)
    {
        [$response] = $options;

        self::assertTrue($response->isSuccessful());
        self::assertEquals('000', $response->getCode());
        self::assertEquals('授權成功。', $response->getMessage());
        self::assertEquals('6636797108956306177', $response->getTransactionId());
        self::assertEquals('PW118120600018', $response->getTransactionReference());
    }

    public function testInvalidCheckMacValue()
    {
        $this->expectException(InvalidResponseException::class);
        $this->expectExceptionMessage('Invalid response from payment gateway');

        $options = [
            'MerchantId' => '1',
            'TerminalId' => '101',
            'PayType' => '1',
            'BookingId' => 'PW118120600018',
            'CustOrderNo' => '6636797108956306177',
            'Amount' => '162',
            'RtnCode' => '000',
            'CheckMacValue' => '21789856e652959fdc6439cfb23068a4066902b',
            'AuthAmount' => '162',
            'RtnMsg' => '授權成功。',
            'PaymentDate' => '2019/08/08',
            'SendType' => '1',
            'Card4no' => '1111',
            'Payment_no' => '2222',
            'TransferOutAccount' => 'foo_account',
        ];
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge($options, [
            'ValidateKey' => 'validateKey',
        ]));

        self::assertEquals(array_merge($options, [
            'PaymentDate' => '2019-08-08',
        ]), $request->getData());
    }
}
