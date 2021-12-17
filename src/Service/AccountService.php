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
     * Information for a single account. 
     * Use this endpoint when you know the account_id. 
     * API key must belong to the same profile as the account.
     *
     * @param string $id
     * @param null|array $params
     */
    public function retrieve($id, $params = null)
    {
        return $this->request('get', $this->buildPath("/accounts/%s", $id), $params);
    }
}
