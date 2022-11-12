## PHP-ETH

PHP integrator with ETH JSON-RPC API

## What It Does

This package allows you to interact with the native ETH JSON-RPC API

## Instalation

Require the composer package

```shell
composer require jr-enterprising\php-eth
```

## Usage

Create a new instance of `EthConnection`

```php
use JrEnterprising\PhpEth\EthConnection;

$connectionUrl = EthConnection::BSC_MAINNET;
$connection = new EthConnection($connectionUrl);

// $connectionUrl can be a local url for a local blockchain, or you can use one of the predefined constants
// EthConnection::BSC_MAINNET
// EthConnection::BSC_TESTNET
```


## Credits

- [Andrei Dumitrescu](https://github.com/andumy)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.