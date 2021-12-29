<?php

namespace StevePolite\Coinbase\Service;

class AccountService extends \StevePolite\Coinbase\Service\AbstractService
{
    /**
     * Get a list of trading accounts from the profile of the API key.
     *
     * @param null|array $params
     */
    public function all()
    {
        return $this->request('get', '/accounts', []);
    }

    /**
     * Information for a single account. 
     * Use this endpoint when you know the account_id. 
     * API key must belong to the same profile as the account.
     *
     * @param string $id
     * @param null|array $params
     */
    public function retrieve($id)
    {
        return $this->request('get', $this->buildPath("/accounts/%s", $id), []);
    }

    /**
     * List the holds of an account that belong to the same profile as the API key. 
     * Holds are placed on an account for any active orders or pending withdraw requests. 
     * As an order is filled, the hold amount is updated. 
     * If an order is canceled, any remaining hold is removed. 
     * For withdrawals, the hold is removed after it is completed.
     * 
     * Query params:
     * string before
     * string after
     * int limit
     * 
     * @param string $id
     * @param null|array $params
     */
    public function holds($id, $params = null)
    {
        return $this->request('get', $this->buildPath("/accounts/%s/holds", $id), $params);
    }

    /**
     * Lists ledger activity for an account. 
     * This includes anything that would affect the accounts balance - transfers, trades, fees, etc.
     * 
     * Query params:
     * string start_date
     * string end_date
     * string before
     * string after
     * int limit
     * string profile_id
     * 
     * @param string $id
     * @param null|array $params
     */
    public function ledger($id, $params = null)
    {
        return $this->request('get', $this->buildPath("/accounts/%s/ledger", $id), $params);
    }

    /**
     * Lists past withdrawals and deposits for an account.
     * 
     * Query params:
     * string before
     * string after 
     * int limit
     * string type
     */
    public function transfers($id, $params = null)
    {
        return $this->request('get', $this->buildPath("/accounts/%s/transfers", $id), $params);
    }
}
