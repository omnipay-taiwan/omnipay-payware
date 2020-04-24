<?php

namespace Omnipay\Payware\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * Does the response require a redirect?
     *
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        $endpoint = $this->getRequest()->getEndpoint();
        $endpoint = (bool) preg_match('/^http(s)?:\/\//', $endpoint)
            ? $endpoint
            : 'https://' . $endpoint;
        $endpoint = $this->getRequest()->getTestMode()
            ? str_replace('www.', 'test.', $endpoint)
            : $endpoint;


        return sprintf('%s/authpay', rtrim($endpoint, '/'));
    }

    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     *
     * @return array
     */
    public function getRedirectData()
    {
        return $this->getData();
    }
}
