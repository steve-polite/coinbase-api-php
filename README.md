# Coinbase API - PHP wrapper

**Note:** this library is not finished yet. It will be completed and released on packagist.org during January 2022.

**Note:** this is not the official PHP client for Coinbase API.  

This is a client library for the [Coinbase Exchange API](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccounts) that it is related to [Coinbase Pro accounts](https://pro.coinbase.com/).  
You can transfer your funds without any fees from your Coinbase account to your Coinbase Pro account [following those instructions](https://help.coinbase.com/en/pro/managing-my-account/funding-your-account/how-to-transfer-funds-between-your-coinbase-pro-and-coinbase-accounts).  

## Installation
```
TODO: update package to packagist.org when finish v1
```

## Authentication
Login to your Coinbase Pro account and create an API key on this page: https://pro.coinbase.com/profile/api.   
Then, save your API key, API passphrase and your API secret.  

You can also create a test account in order to test your trades on [Coinbase Pro Sandbox](https://public.sandbox.pro.coinbase.com/trade).  
In the sandbox enviroment you can top-up your accounts with fake currencies amount in order to test your trades.

Then, create a new instance of this library:  
``` php
$coinbase = new \StevePolite\Coinbase\CoinbaseClient([
    'api_key' => '{YOUR API KEY}',
    'api_secret' => '{YOUR API SECRET}',
    'api_passphrase' => '{YOUR API PASSPHRASE}',
    'is_sandbox' => true // 
]);
```

## Pagination
```
TODO: define pagination logic
```

## Managed APIs 
### Accounts
#### Get all accounts for a profile
Get a list of trading accounts from the profile of the API key.  
[Docs link](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccounts)
``` php
$accounts = $coinbase->accounts->all();
```

#### Get a single account by id
Information for a single account. Use this endpoint when you know the ```account_id```. API key must belong to the same profile as the account.  
[Docs link](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccount)
``` php
$account = $coinbase->accounts->retrieve("ACCOUNT_ID");
```

#### Get a single account's holds
List the holds of an account that belong to the same profile as the API key. Holds are placed on an account for any active orders or pending withdraw requests. As an order is filled, the hold amount is updated. If an order is canceled, any remaining hold is removed. For withdrawals, the hold is removed after it is completed.  
[Docs link](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccountholds)
``` php
// $params is optional, you can use an empty array instead
$params = [
    "before" => string,
    "after" => string,
    "limit" => int
];

$holds = $coinbase->accounts->holds("ACCOUNT_ID", $params);
```  

#### Get a single account's ledger
Lists ledger activity for an account. This includes anything that would affect the accounts balance - transfers, trades, fees, etc.  
[Docs link](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccountledger)
``` php
// $params is optional, you can use an empty array instead
$params = [
    "start_date" => string,
    "end_date" => string,
    "before" => string,
    "after" => string,
    "limit" => int,
    "profile_id" => string
];

$ledger = $coinbase->accounts->ledger("ACCOUNT_ID", $params);
```

#### Get a single account's transfers
Lists past withdrawals and deposits for an account.  
[Docs link](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccounttransfers)
``` php
// $params is optional, you can use an empty array instead
$params = [
    "before" => string,
    "after" => string,
    "limit" => int,
    "type" => string
];

$transfers = $coinbase->accounts->transfers("ACCOUNT_ID", $params);
```   

### Coinbase Accounts
#### Get all Coinbase wallets
Gets all the user's available Coinbase wallets (These are the wallets/accounts that are used for buying and selling on www.coinbase.com).  
[Docs link](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getcoinbaseaccounts)
``` php
$wallets = $coinbase->coinbase_accounts->all();
```

#### Generate crypto address
Generates a one-time crypto address for depositing crypto.  
[Docs link](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_postcoinbaseaccountaddresses)  
``` php
$address = $coinbase->coinbase_accounts->address("ACCOUNT_ID");
```