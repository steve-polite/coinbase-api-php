<?php

namespace StevePolite\Coinbase\Util;

class Util
{
    /**
     * Convert curl response to Coinbase object
     * 
     * @param int $http_code
     * @param array $header
     * @param null|array|object $json
     */
    public static function convertToCoinbaseObject(int $http_code, array $header, $json)
    {
        if (\is_object($json)) {
            return $json;
        }

        if (\is_array($json)) {
            return new \StevePolite\Coinbase\CoinbaseListObject("list", $header, $json);
        }

        return null;
    }
}
