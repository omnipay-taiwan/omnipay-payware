<?php

namespace Omnipay\Payware\Traits;

trait HasDomain
{
    /**
     * @param $domain
     * @return $this
     */
    public function setDomain($domain)
    {
        return $this->setParameter('domain', $domain);
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->getParameter('domain');
    }
}
