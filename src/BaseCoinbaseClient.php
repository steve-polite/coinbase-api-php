<?php

namespace StevePolite\Coinbase;

class BaseCoinbaseClient
{
    const DEFAULT_API_BASE = "https://api.exchange.coinbase.com";

    const SANDBOX_API_BASE = "https://api-public.sandbox.exchange.coinbase.com";

    /**
     * @var array
     */
    private $config;

    /**
     * Initialize a new instance of the {@link BaseCoinbaseClient} class.
     *  
     */
    public function __construct(array $config = [])
    {
        $config = \array_merge($this->getDefaultConfig(), $config);
        $this->validateConfig($config);

        $this->config = $config;
    }

    public function request($method, $path, $query_params, $body_params = null)
    {
        $requestor = new \StevePolite\Coinbase\ApiRequestor(
            $this->getApiBase(),
            $this->getApiKey(),
            $this->getApiSecret(),
            $this->getApiPassphrase()
        );

        if (!\is_null($query_params)) {
            $path .= "?" . \http_build_query($query_params);
        }

        $response = $requestor->request($method, $path, $body_params);
        return $response;
    }

    /**
     * Gets the API key used by the client to send requests.
     *
     * @return null|string the API key used by the client to send requests
     */
    public function getApiKey()
    {
        return $this->config['api_key'];
    }

    /**
     * Gets the API secret used by the client to authenticate requests.
     *
     * @return null|string the API secret used by the client to send requests
     */
    public function getApiSecret()
    {
        return $this->config['api_secret'];
    }

    /**
     * Gets the API passphrase used by the client to authenticate requests.
     *
     * @return null|string the API passphrase used by the client to send requests
     */
    public function getApiPassphrase()
    {
        return $this->config['api_passphrase'];
    }

    /**
     * Gets the base URL for Coinbase's API.
     *
     * @return string the base URL for Coinbase's API
     */
    public function getApiBase()
    {
        if ($this->config['is_sandbox']) {
            return self::SANDBOX_API_BASE;
        }

        return $this->config['api_base'];
    }

    /**
     *
     * @return array<string, mixed>
     */
    private function getDefaultConfig()
    {
        return [
            'api_key' => null,
            'api_secret' => null,
            'api_passphrase' => null,
            'api_base' => self::DEFAULT_API_BASE,
            'is_sandbox' => false,
        ];
    }

    /**
     * @param array<string, mixed> $config
     *
     * @throws \StevePolite\Coinbase\Exception\InvalidArgumentException
     */
    private function validateConfig(array $config)
    {
        // api_key
        if (!\is_string($config['api_key'])) {
            throw new \StevePolite\Coinbase\Exception\InvalidArgumentException('api_key must be a string');
        }

        // api_secret
        if (!\is_string($config['api_secret'])) {
            throw new \StevePolite\Coinbase\Exception\InvalidArgumentException('api_secret must be a string');
        }

        // api_passphrase
        if (!\is_string($config['api_passphrase'])) {
            throw new \StevePolite\Coinbase\Exception\InvalidArgumentException('api_passphrase must be a string');
        }

        // is_sandbox
        if (\array_key_exists('is_sandbox', $config) && !is_bool($config['is_sandbox'])) {
            throw new \StevePolite\Coinbase\Exception\InvalidArgumentException('is_sandbox must be a boolean value');
        }
    }
}
