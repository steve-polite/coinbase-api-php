<?php

namespace StevePolite\Coinbase\Service;

class CoinbaseAccountService extends \StevePolite\Coinbase\Service\AbstractService
{
    /**
     * Gets all the user's available Coinbase wallets 
     * (These are the wallets/accounts that are used for buying and selling on www.coinbase.com)
     * 
     */
    public function all()
    {
        return $this->request('get', '/coinbase-accounts', null);
    }

    /**
     * Generates a one-time crypto address for depositing crypto.
     * 
     * @param string $id
     */
    public function address($id)
    {
        return $this->request('post', $this->buildPath('/coinbase-accounts/%s/addresses', $id), null);
    }
}
