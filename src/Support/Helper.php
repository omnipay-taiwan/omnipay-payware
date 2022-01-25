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

    public static function fixBarcode($data)
    {
        if (array_key_exists('Barcode1~3', $data)) {
            $data['Barcode1_3'] = $data['Barcode1~3'];
            unset($data['Barcode1~3']);
        }

        return $data;
    }

    public static function filterEmpty($data = [])
    {
        return array_filter($data, function ($value) {
            return ! empty($value);
        });
    }
}
