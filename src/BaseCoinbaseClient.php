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

    public function request($method, $path, $params)
    {
        $ch = \curl_init();
        \curl_setopt($ch, \CURLOPT_URL, $this->getApiBase() . $path);
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_HTTPHEADER, $this->getCoinbaseAuthHeader($path, '', $method));

        $method = \trim(\strtolower($method));
        if ($method === "post") \curl_setopt($ch, \CURLOPT_POST, 1);

        $response = \curl_exec($ch);

        \curl_close($ch);

        // test squash 1-3

        return json_decode($response);
    }

    /**
     * Create Coinbase API header for authenticated API calls
     * 
     * @param string $path
     * @param null|string|array $body
     * @param string $method
     * 
     * @return array the header for auth API calls
     */
    private function getCoinbaseAuthHeader(string $path, $body, string $method): array
    {
        $timestamp = time();
        return [
            'User-Agent: steve-polite/coinbase-api-php',
            'Content-Type: application/json',
            'CB-ACCESS-KEY: ' . $this->getApiKey(),
            'CB-ACCESS-SIGN: ' . $this->getSignature($path, $body, $method, $timestamp),
            'CB-ACCESS-TIMESTAMP: ' . $timestamp,
            'CB-ACCESS-PASSPHRASE: ' . $this->getApiPassphrase()
        ];
    }

    /**
     * Create CB-ACCESS-SIGN header for Coinbase API authentication
     * 
     * @param string $path
     * @param null|string|array $body
     * @param string $method
     * @param integer $timestamp
     * 
     * @return string the signature used to CB-ACCESS-SIGN header
     */
    private function getSignature(string $path, $body, string $method, int $timestamp): string
    {
        if (\is_array($body)) $body = json_encode($body);
        elseif (\is_null($body)) $body = '';

        $what = $timestamp . \strtoupper($method) . $path . $body;

        return \base64_encode(\hash_hmac("sha256", $what, \base64_decode($this->getApiSecret()), true));
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
