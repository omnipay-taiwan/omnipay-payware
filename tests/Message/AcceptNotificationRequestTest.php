<?php

namespace Omnipay\Payware\Tests\Message;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Payware\Message\AcceptNotificationRequest;
use Omnipay\Tests\TestCase;

class AcceptNotificationRequestTest extends TestCase
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
        ];
        $request = new AcceptNotificationRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge($options, [
            'ValidateKey' => 'validateKey',
        ]));

        self::assertEquals(array_merge($options, [
            'PaymentDate' => '2019-08-08',
        ]), $request->getData());

        return [$request];
    }

    /**
     * @depends testGetData
     * @param array $result
     */
    public function testSend($result)
    {
        list($notification) = $result;

        self::assertEquals('6636797108956306177', $notification->getTransactionId());
        self::assertEquals('PW118120600018', $notification->getTransactionReference());
        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $notification->getTransactionStatus());
        self::assertEquals('OK', $notification->getMessage());
    }
}
