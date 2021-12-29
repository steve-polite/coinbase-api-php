<?php

namespace StevePolite\Coinbase\Service;

class ConversionService extends \StevePolite\Coinbase\Service\AbstractService
{
    /**
     * Converts funds from from currency to to currency. 
     * Funds are converted on the from account in the profile_id profile.
     * 
     * @param array $body
     */
    public function convert(array $body)
    {
        return $this->request('post', '/conversions', [], $body);
    }

    /**
     * Gets a currency conversion by id (i.e. USD -> USDC).
     * 
     * @param string $conversion_id
     * @param null|array $params
     */
    public function retrieve(string $conversion_id, $params = null)
    {
        return $this->request('get', $this->buildPath('/conversions/%s', $conversion_id), $params);
    }
}
