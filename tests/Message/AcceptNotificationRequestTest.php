<?php

namespace Omnipay\Payware\Tests\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Payware\Message\AcceptNotificationRequest;
use Omnipay\Tests\TestCase;

class AcceptNotificationRequestTest extends TestCase
{
    public function testGetData()
    {
        $data = [
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
        $this->getHttpRequest()->request->add($data);
        $request = new AcceptNotificationRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(['ValidateKey' => 'validateKey']);

        self::assertEquals(array_merge($data, ['PaymentDate' => '2019/08/08']), $request->getData());

        return [$request];
    }

    /**
     * @depends testGetData
     *
     * @param  array  $result
     */
    public function testSend($result)
    {
        $notification = $result[0];

        self::assertEquals('6636797108956306177', $notification->getTransactionId());
        self::assertEquals('PW118120600018', $notification->getTransactionReference());
        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $notification->getTransactionStatus());
        self::assertEquals('授權成功。', $notification->getMessage());
        // self::assertEquals('OK', $notification->getReply());
    }

    public function testInvalidCheckMacValue()
    {
        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessage('Incorrect CheckMacValue');

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
        $this->getHttpRequest()->request->add($options);
        $request = new AcceptNotificationRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(['ValidateKey' => 'validateKey']);

        self::assertEquals(array_merge($options, [
            'PaymentDate' => '2019-08-08',
        ]), $request->getData());
    }
}
