# pokerhands

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/thephpleague/skeleton/master.svg?style=flat-square)](https://travis-ci.org/thephpleague/skeleton)

This PHP package reads poker hands from a file and returns the list of the hands sorted by the rank from highest to lowest. 

## Install

Via Composer

``` bash
$ composer require enisshala/pokerhands
```

## Usage

``` php
$hands = new enisshala\PokerClass();
echo $hands->sortHands($hands_file);
```

## Contributing

Please see [CONTRIBUTING](https://github.com/thephpleague/:package_name/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Enis Shala](https://github.com/enisshala)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
