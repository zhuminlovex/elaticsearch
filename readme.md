# Elaticsearch

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` 
$ composer require haode/elaticsearch
```

## Usage

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email 47876800@qq.com instead of using the issue tracker.

## Credits

- [zhum][link-author]
- [All Contributors][link-contributors]

## License

1.01. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/haode/elaticsearch.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/haode/elaticsearch.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/haode/elaticsearch/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/haode/elaticsearch
[link-downloads]: https://packagist.org/packages/haode/elaticsearch
[link-travis]: https://travis-ci.org/haode/elaticsearch
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/haode
[link-contributors]: ../../contributors


``` bash
$ composer require haode/elaticsearch
```
## 搜索查询
在model 中引用trait
``` bash
use Searchable;
```
## 同步数据库中的数据
``` bash
 php artisan elaticsearch:import "App\Models\Orm"
```

