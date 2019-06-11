# Cayman Brothers StockShare SDK (v1.0)
[![Latest Stable Version](http://img.shields.io/badge/Latest%20Stable-1.0-blue.svg)](https://packagist.org/packages/caymanbrothers/stockshare-sdk)

PHP SDK developed by Cayman Brothers Corporation for the analysis and valuation of equity derivative options.

## Installation

The Cayman Brothers StockShare SDK can be installed with [Composer](https://getcomposer.org/). Run this command:

```sh
composer require caymanbrothers/stockshare-sdk
```

A short installation guide can also be found [here](https://l.stefankuehnel.com/v7yD1) as a video.

## Usage

> **Note:** This version of the Cayman Brothers StockShare SDK for PHP requires PHP 5.3 or greater.

Simple calculation of a call option using the Black-Scholes model.

```php
require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

$BlackScholes = new \CaymanBrothers\CaymanBrothers();

try {
    print_r($BlackScholes->calculate([
        'model' => 'BlackScholes',
        'options' => ['Call', 'Put'],
        'greeks' => true,
        'values' => [
            'underlying_price' => 1000,
            'strike' => 970,
            'expiration' => 92,
            'interest_rate' => 0.06,
            'volatility' => 0.2,
            'dividend_yield' => 0
        ]
    ]));
} catch (\Exception $e) {
    echo $e->getMessage();
}
```

## License

Please see the [license file](https://github.com/caymanbrothers/stockshare-sdk/blob/master/LICENSE) for more information.

## Security Vulnerabilities

If you have found a security issue, please contact the maintainers directly at [stefankuehnel.com/contact](https://stefankuehnel.com/contact).
