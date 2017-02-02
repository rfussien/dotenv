# dotenv

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## Requirements

PHP >= 5.6 | >= 7.0 | >= 7.1 <br>
:warning:
**HHVM not supported so far**
:warning:

## Install

Via Composer

``` bash
$ composer require rfussien/dotenv
```

## Usage

``` php
$dotenv = new Rfussien\Dotenv\Loader(__DIR__);
$dotenv->load();

// optionally you can set a different filename (by defaul .env)
$dotenv = new Rfussien\Dotenv\Loader(__DIR__, '.my.env');
$dotenv->load();

```

## Why should I use this dotenv loader instead of another ?

This package is meant to be faster than the other dotenv loaders.<br>
But please, don't believe me, check my [small benchmark](https://github.com/rfussien/dotenv-benchmark) out, and try it by yourself.

It has less features, but common, it's about a config file and a minimum
computing should be done...

IMHO:
 - A real boolean **MUST NOT** be between quotes
 - A string **SHOULD** be between quotes or double quotes
 - An empty value is **not null**, but an empty string
 - Computing nested values every single time my app runs is a waste of time

## Results

| In the .env                       | type       | value                 |
|-----------------------------------|------------|-----------------------|
| K01=true                          | bool       | true                  |
| K02=tRuE                          | bool       | true                  |
| K03="true"                        | string(4)  | "true"                |
| K04=on                            | bool       | true                  |
| K05=On                            | bool       | true                  |
| K06="on"                          | string(2)  | "on"                  |
| K07=yes                           | bool       | true                  |
| K08=Yes                           | bool       | true                  |
| K09="yes"                         | string(3)  | "yes"                 |
| K10=false                         | bool       | false                 |
| K11=fAlSe                         | bool       | false                 |
| K12="false"                       | string(5)  | "false"               |
| K13=off                           | bool       | false                 |
| K14=Off                           | bool       | false                 |
| K15="off"                         | string(3)  | "off"                 |
| K16=no                            | bool       | false                 |
| K17=No                            | bool       | false                 |
| K18="no"                          | string(2)  | "no"                  |
| K19=1                             | int        | 1                     |
| K20=1.1                           | double     | 1.1                   |
| K21=value                         | string(5)  | "value"               |
| K22="value"                       | string(5)  | "value"               |
| K23="VaLuE"                       | string(5)  | "VaLuE"               |
| K24=VaLuE                         | string(5)  | "VaLuE"               |
| K25="value \" value"              | string(13) | "value " value"       |
| K26="value \"value\" value"       | string(19) | "value "value" value" |
| K27="value 'value' value"         | string(19) | "value 'value' value" |
| K28=""                            | string(0)  | ""                    |
| K29=                        value | string(5)  | "value"               |
| K30='value'                       | string(5)  | "value"               |
| K31=''                            | string(0)  | ""                    |
| K32=                              | string(0)  | ""                    |
| K33=null                          | NULL       | NULL                  |

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email remi.fussien@gmail.com instead of using the issue tracker.

## Credits

- [Remi FUSSIEN][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/rfussien/dotenv.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rfussien/dotenv/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rfussien/dotenv.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/rfussien/dotenv.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rfussien/dotenv.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/rfussien/dotenv
[link-travis]: https://travis-ci.org/rfussien/dotenv
[link-scrutinizer]: https://scrutinizer-ci.com/g/rfussien/dotenv/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/rfussien/dotenv
[link-downloads]: https://packagist.org/packages/rfussien/dotenv
[link-author]: https://github.com/rfussien
[link-contributors]: ../../contributors
