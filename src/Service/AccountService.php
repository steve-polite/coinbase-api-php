<?php

namespace StevePolite\Coinbase\Service;

class AccountService extends \StevePolite\Coinbase\Service\AbstractService
{
    /**
     * Get a list of trading accounts from the profile of the API key.
     *
     * @param null|array $params
     */
    public function all($params = null)
    {
        return $this->request('get', '/accounts', $params);
    }

    /**
     * Get a list of trading accounts from the profile of the API key.
     *
     * @param string $id
     * @param null|array $params
     */
    public function retrieve($id, $params = null)
    {
        return $this->request('get', $this->buildPath("/accounts/%s", $id), $params);
    }
}
