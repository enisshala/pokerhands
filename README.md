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

## Testing with CLI
in the root folder of the package there is IndexTest.php, you can run it in terminal with following command
``` php
php -r "include 'IndexTest.php'; IndexTest::test('https://pastebin.com/raw/FXneUYCc');"
```
I used Pastebin for hands and reading from file, some of the hands i used:
````
https://pastebin.com/raw/FXneUYCc
https://pastebin.com/raw/4xRPSB9j
https://pastebin.com/raw/5Mn3z8m1
````
## Contributing

Please see [CONTRIBUTING](https://github.com/thephpleague/:package_name/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Enis Shala](https://github.com/enisshala)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
