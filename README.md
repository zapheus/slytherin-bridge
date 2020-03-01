# Slytherin Integration Bridge

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Converts Slytherin Integrations to [Zapheus](https://github.com/zapheus/zapheus) providers.

## Installation

Install `Slytherin Bridge` via [Composer](https://getcomposer.org/):

``` bash
$ composer require zapheus/slytherin-bridge
```

## Basic Usage

``` php
use Acme\Integrations\AuthIntegration;
use Acme\Integrations\RoleIntegration;
use Rougin\Slytherin\Container\Container;
use Zapheus\Bridge\Slytherin\BridgeProvider;
use Zapheus\Container\Container;

$providers = array(new AuthIntegration, new RoleIntegration);

$provider = new BridgeProvider($providers);

$container = $provider->register(new Container);

$slytherin = $container->get(BridgeProvider::CONTAINER);
```

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Credits

- [All contributors][link-contributors]

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-code-quality]: https://img.shields.io/scrutinizer/g/zapheus/slytherin-bridge.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/zapheus/slytherin-bridge.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/zapheus/slytherin-bridge.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/zapheus/slytherin-bridge/master.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/zapheus/slytherin-bridge.svg?style=flat-square

[link-changelog]: https://github.com/zapheus/slytherin-bridge/blob/master/CHANGELOG.md
[link-code-quality]: https://scrutinizer-ci.com/g/zapheus/slytherin-bridge
[link-contributors]: https://github.com/zapheus/slytherin-bridge/contributors
[link-downloads]: https://packagist.org/packages/zapheus/slytherin-bridge
[link-license]: https://github.com/zapheus/slytherin-bridge/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/zapheus/slytherin-bridge
[link-scrutinizer]: https://scrutinizer-ci.com/g/zapheus/slytherin-bridge/code-structure
[link-travis]: https://travis-ci.org/zapheus/slytherin-bridge