<?php

namespace StevePolite\Coinbase\Service;

class CoreServiceFactory extends \StevePolite\Coinbase\Service\AbstractServiceFactory
{
    private static $class_map = [
        'accounts' => AccountService::class,
        'coinbase_accounts' => CoinbaseAccountService::class,
        'conversions' => ConversionService::class,
        'currencies' => CurrencyService::class,
    ];

    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}
