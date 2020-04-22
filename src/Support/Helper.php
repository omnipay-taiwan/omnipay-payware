<?php

namespace Omnipay\Payware\Support;

class Helper
{
    /**
     * @param string $date
     * @param string $format
     * @return string
     */
    public static function parseDate($date, $format = null)
    {
        if (! $date) {
            return $date;
        }

        return ! $format
            ? str_replace('/', '-', $date)
            : date($format, strtotime($date));
    }
}
