<?php

namespace christopheraseidl\Reflect\Tests;

use christopheraseidl\Reflect\Reflect;

abstract class StaticParent
{
    private static string $extended = 'extended static property';

    private static function extendedMethod()
    {
        return 'extended static method';
    }
}

abstract class StaticTestClass extends StaticParent {
    private static string $static = 'private static property';

    private string $instanced = 'my property';

    private static function method(): string
    {
        return 'private static method';
    }
}

beforeEach(function () {
    $this->class = Reflect::on(StaticTestClass::class);

    if($this->class->static !== 'private static property') {
        $this->class->static = 'private static property';
    }

    if($this->class->extended !== 'extended static property') {
        $this->class->extended = 'extended static property';
    }
});

it('can read a static private property', function () {    
    expect($this->class->static)->toBe('private static property')
        ->and($this->class->extended)->toBe('extended static property');
});

it('can set a static private property', function () {
    $this->class->static = 'private';
    $this->class->extended = 'extended';
    
    expect($this->class->static)->toBe('private')
        ->and($this->class->extended)->toBe('extended');
});

it('can call a static private method', function () {
    expect($this->class->method())->toBe('private static method')
        ->and($this->class->extendedMethod())->toBe('extended static method');
});

it('returns an exception when accessing an instanced property on a static reflection', function () {
    expect(fn() => $this->class->instanced)->toThrow(\Error::class);
});