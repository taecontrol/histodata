# Laravel package to store historical data

[![Latest Version on Packagist](https://img.shields.io/packagist/v/taecontrol/histodata.svg?style=flat-square)](https://packagist.org/packages/taecontrol/histodata)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/taecontrol/histodata/run-tests?label=tests)](https://github.com/taecontrol/histodata/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/taecontrol/histodata/Check%20&%20fix%20styling?label=code%20style)](https://github.com/taecontrol/histodata/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/taecontrol/histodata.svg?style=flat-square)](https://packagist.org/packages/taecontrol/histodata)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

Histodata is a Laravel package for storing historical data in Timescale DB.

## Installation

You can install the package via composer:

```bash
composer require taecontrol/histodata
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Taecontrol\Histodata\HistodataServiceProvider" --tag="histodata-migrations"
php artisan migrate
```

## Requirements

- Timescale DB
- Cache driver like Redis or Memcached

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Luis Güette](https://github.com/lguette)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
