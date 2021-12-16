<?php

namespace StevePolite\Coinbase\Service;

/**
 * Abstract base class for all service factories used to expose service
 * instances through {@link \StevePolite\Coinbase\CoinbaseClient}.
 *
 * Service factories serve two purposes:
 *
 * 1. Expose properties for all services through the `__get()` magic method.
 * 2. Lazily initialize each service instance the first time the property for
 *    a given service is used.
 */
abstract class AbstractServiceFactory
{
    private $client;

    private $services;

    public function __construct($client)
    {
        $this->client = $client;
        $this->services = [];
    }

    /**
     * @param string $name
     *
     * @return null|string
     */
    abstract protected function getServiceClass($name);

    /**
     * @param string $name
     *
     * @return null|AbstractService|AbstractServiceFactory
     */
    public function __get($name)
    {
        $service_class = $this->getServiceClass($name);
        if (null !== $service_class) {
            if (!\array_key_exists($name, $this->services)) {
                $this->services[$name] = new $service_class($this->client);
            }

            return $this->services[$name];
        }

        \trigger_error('Undefined property: ' . static::class . '::$' . $name);

        return null;
    }
}
