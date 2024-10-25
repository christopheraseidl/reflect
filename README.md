# An easy way to utilize the power of PHP's ReflectionClass.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/christopheraseidl/reflect.svg?style=flat-square)](https://packagist.org/packages/christopheraseidl/reflect)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/christopheraseidl/reflect/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/christopheraseidl/reflect/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/christopheraseidl/reflect/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/christopheraseidl/reflect/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/christopheraseidl/reflect.svg?style=flat-square)](https://packagist.org/packages/christopheraseidl/reflect)

Reflect is a simple wrapper around PHP's ReflectionClass that provides easy access to private properties and methods, supporting both instanced and static members with inheritance.

## PHP Versions

- PHP 8.0+

## Installation

You can install Reflect via composer:
```bash
composer require christopheraseidl/reflect
```

## Usage

### Accessing instance members

```php
class MyClass {
    private string $private = 'private property';
    private function method(): string 
    {
        return 'private method';
    }
}

$reflect = Reflect::on(new MyClass());
echo $reflect->private; // 'private property'
echo $reflect->method(); // 'private method'
```

### Accessing static members
```php
class MyStaticClass {
    private static string $static = 'static property';
    private static function staticMethod(): string 
    {
        return 'static method';
    }
}

$reflect = Reflect::on(MyStaticClass::class);
echo $reflect->static; // 'static property'
echo $reflect->staticMethod(); // 'static method'
```

### Inheritance support
```php
class ParentClass {
    private string $parentProp = 'parent property';
}

class Child extends ParentClass {
    private string $childProp = 'child property';
}

$reflect = Reflect::on(new Child());
echo $reflect->parentProp; // 'parent property'
echo $reflect->childProp; // 'child property'
```

### Non-instantiable classes
```php
abstract class AbstractClass {
    private static string $env = 'development';
}

$reflect = Reflect::on(AbstractClass::class);
echo $reflect->env; // 'development'
```

## Testing

```bash
composer test
```

## Credits

- [Chris Seidl](https://github.com/christopheraseidl)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
