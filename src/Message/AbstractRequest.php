<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\Payware\Support\Helper;

abstract class AbstractRequest extends BaseAbstractRequest
{
    public function initialize(array $parameters = [])
    {
        return parent::initialize(Helper::fixBarcode($parameters));
    }
}
