<?php

namespace StevePolite\Coinbase\Service;

class CurrencyService extends \StevePolite\Coinbase\Service\AbstractService
{
    /**
     * Gets a list of all known currencies.
     * Note: Not all currencies may be currently in use for trading.
     * 
     */
    public function all()
    {
        return $this->request('get', '/currencies', []);
    }

    /**
     * Gets a single currency by id.
     * 
     * @param string $currency_id
     */
    public function retrieve(string $currency_id)
    {
        return $this->request('get', $this->buildPath('/currencies/%s', $currency_id), []);
    }
}
