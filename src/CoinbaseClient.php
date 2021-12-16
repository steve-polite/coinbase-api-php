<?php

namespace StevePolite\Coinbase;

class CoinbaseClient extends BaseCoinbaseClient
{
    /**
     * @var \StevePolite\Coinbase\Service\CoreServiceFactory
     */
    private $core_service_factory;

    public function __get($name)
    {
        if (null === $this->core_service_factory) {
            $this->core_service_factory = new \StevePolite\Coinbase\Service\CoreServiceFactory($this);
        }

        return $this->core_service_factory->__get($name);
    }
}
