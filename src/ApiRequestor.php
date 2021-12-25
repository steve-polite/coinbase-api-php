<?php

namespace StevePolite\Coinbase;

class ApiRequestor
{
    /**
     * @var array<string> a list of headers that should be persisted across requests
     */
    public static $HEADERS_TO_PERSIST = [
        'cb-before',
        'cb-after',
    ];

    /**
     * @var string
     */
    private $_api_base;

    /**
     * @var string
     */
    private $_api_key;

    /**
     * @var string
     */
    private $_api_secret;

    /**
     * @var string
     */
    private $_api_passphrase;

    /**
     * Api Requestor constructor
     * 
     * @param string $api_key
     * @param string $api_secret
     * @param string $api_passphrase
     */
    public function __construct(string $api_base, string $api_key, string $api_secret, string $api_passhprase)
    {
        $this->_api_base = $api_base;
        $this->_api_key = $api_key;
        $this->_api_secret = $api_secret;
        $this->_api_passphrase = $api_passhprase;
    }

    /**
     * @param string $method
     * @param string $url
     * @param null|array $params
     * @param null|array $headers
     * 
     * @return array
     */
    public function request(string $method, string $path, $body_params = null)
    {
        $body_params = $body_params ?: [];
        $headers = $this->getCoinbaseAuthHeader($path, $method, $body_params);

        $ch = \curl_init();
        \curl_setopt($ch, \CURLOPT_URL, $this->_api_base . $path);
        \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, \CURLOPT_HTTPHEADER, $headers);
        \curl_setopt($ch, \CURLOPT_HEADER, true);

        $method = \trim(\strtolower($method));
        if ($method === "post") {
            \curl_setopt($ch, \CURLOPT_POST, 1);
        }

        $response = \curl_exec($ch);

        $header_size = \curl_getinfo($ch, \CURLINFO_HEADER_SIZE);
        $header = \substr($response, 0, $header_size);
        $body = \substr($response, $header_size);
        $http_code = \curl_getinfo($ch, \CURLINFO_RESPONSE_CODE);

        \curl_close($ch);

        $header = $this->parseStringHeaders($header);
        $header = $this->discardNonPersistentHeaders($header);

        $json = \json_decode($body);

        /**
         * TODO: manage errors (e.g. {"message": "NotFound"})
         */
        $obj = \StevePolite\Coinbase\Util\Util::convertToCoinbaseObject((int) $http_code, $header, $json);

        return $obj;
    }

    /**
     * Create Coinbase API header for authenticated API calls
     * 
     * @param string $path
     * @param string $method
     * @param null|string|array $params
     * 
     * @return array the header for auth API calls
     */
    private function getCoinbaseAuthHeader(string $path, string $method, $body_params = null): array
    {
        $timestamp = time();

        return [
            'User-Agent: steve-polite/coinbase-api-php',
            'Content-Type: application/json',
            'CB-ACCESS-KEY: ' . $this->_api_key,
            'CB-ACCESS-SIGN: ' . $this->getSignature($path, $method, $timestamp, $body_params),
            'CB-ACCESS-TIMESTAMP: ' . $timestamp,
            'CB-ACCESS-PASSPHRASE: ' . $this->_api_passphrase
        ];
    }

    /**
     * Create CB-ACCESS-SIGN header for Coinbase API authentication
     * 
     * @param string $path
     * @param string $method
     * @param integer $timestamp
     * @param null|string|array $params
     * 
     * @return string the signature used to CB-ACCESS-SIGN header
     */
    private function getSignature(string $path, string $method, int $timestamp, $body_params = null): string
    {
        if (\is_array($body_params) && \count($body_params) === 0) $body_params = '';
        elseif (\is_array($body_params)) $body_params = json_encode($body_params);
        elseif (\is_null($body_params)) $body_params = '';

        $what = $timestamp . \strtoupper($method) . $path . $body_params;

        return \base64_encode(\hash_hmac("sha256", $what, \base64_decode($this->_api_secret), true));
    }

    /**
     * Explode string headers to key/value array
     * 
     * @param string $raw_header
     * 
     * @return array key/value array headers
     */
    private function parseStringHeaders(string $raw_header)
    {
        $raw_header = \explode("\r\n", $raw_header);
        $parsed_header = [];
        foreach ($raw_header as &$header) {
            if (\strlen($header) > 0) {
                if (\strpos($header, ":") > 0) {
                    $parsed_header[\substr($header, 0, \strpos($header, ":"))]
                        = \trim(\substr($header, \strpos($header, ":") + 1));
                }
            }
        }
        return $parsed_header;
    }

    /**
     * Remove all headers that we don't want to persist across requests
     * 
     * @param array $headers
     * 
     * @return array clean haeder list
     */
    private function discardNonPersistentHeaders(array $headers): array
    {
        foreach ($headers as $header_key => $header_value) {
            if (!\in_array($header_key, self::$HEADERS_TO_PERSIST, true)) {
                unset($headers[$header_key]);
            }
        }
        return $headers;
    }
}
