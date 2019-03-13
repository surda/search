# Search control

[![Build Status](https://travis-ci.org/surda/search.svg?branch=master)](https://travis-ci.org/surda/search)
[![Licence](https://img.shields.io/packagist/l/surda/search.svg?style=flat-square)](https://packagist.org/packages/surda/search)
[![Latest stable](https://img.shields.io/packagist/v/surda/search.svg?style=flat-square)](https://packagist.org/packages/surda/search)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)


## Installation

The recommended way to is via Composer:

```
composer require surda/search
```

After that you have to register extension in config.neon:

```yaml
extensions:
    search: Surda\Search\DI\SearchExtension
```

## Configuration

Default
```yaml
search:
    templates:
        default: bootstrap4.default.latte
    autocomplete: 'on'
```

## Usage

Presenter

```php
use Nette\Application\UI\Presenter;
use Surda\Search\TSearch;

class ProductPresenter extends Presenter
{
    use TSearch;
    
    public function actionDefault(): void
    {
        $text = $this->search;
        ... 
    }
}
```
Template

```html
{control search}
```

