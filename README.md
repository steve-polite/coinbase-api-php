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
    'is_sandbox' => true // true if it is a sandbox API key, false or omit if it is a live API key
]);
```  
  

## Pagination
```
TODO: define pagination logic
```  
  

  
## Managed APIs 
### Accounts
#### Get all accounts for a profile [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccounts)
``` php
$accounts = $coinbase->accounts->all();
```

#### Get a single account by id [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccount)
``` php
$account = $coinbase->accounts->retrieve("ACCOUNT_ID");
```

#### Get a single account's holds [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccountholds)
``` php
$params = [
    "before" => ?string,
    "after" => ?string,
    "limit" => ?int
];

$holds = $coinbase->accounts->holds("ACCOUNT_ID", $params);
```  

#### Get a single account's ledger [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccountledger)
``` php
$params = [
    "start_date" => ?string,
    "end_date" => ?string,
    "before" => ?string,
    "after" => ?string,
    "limit" => ?int,
    "profile_id" => ?string
];

$ledger = $coinbase->accounts->ledger("ACCOUNT_ID", $params);
```

#### Get a single account's transfers [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getaccounttransfers)
``` php
$params = [
    "before" => ?string,
    "after" => ?string,
    "limit" => ?int,
    "type" => ?string
];

$transfers = $coinbase->accounts->transfers("ACCOUNT_ID", $params);
```   
  
    
    
### Coinbase Accounts
#### Get all Coinbase wallets [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getcoinbaseaccounts)
``` php
$wallets = $coinbase->coinbase_accounts->all();
```

#### Generate crypto address [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_postcoinbaseaccountaddresses)  
``` php
$address = $coinbase->coinbase_accounts->address("ACCOUNT_ID");
```  
   

  
### Conversions  
#### Convert currency [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_postconversion)
``` php
$params = [
    'profile_id' => ?string,
    'from' => string,
    'to' => string,
    'amount' => string,
    'nonce' => ?string 
];
$conversion = $coinbase->conversions->convert($params);
```  
  
#### Get a conversion [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getconversion)
``` php
$params = [
    'profile_id' => ?string
];
$conversion = $coinbase->conversions->retrieve("CONVERSION_ID", $params);
```  
  


### Currencies  
#### Get all know currencies [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getcurrencies)
``` php
$currencies = $coinbase->currencies->all();
```  
  
#### Get a currency [(docs)](https://docs.cloud.coinbase.com/exchange/reference/exchangerestapi_getcurrency)
``` php
$currency = $coinbase->currencies->retrieve("CURRENCY_ID");
```  
