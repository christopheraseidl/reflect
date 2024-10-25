<?php

namespace christopheraseidl\Reflect\Tests;

use christopheraseidl\Reflect\Reflect;

class Grandparent
{
    private string $grandparent = 'grandparent property';
}

class ParentClass extends Grandparent
{
    private string $extended = 'extended property';

    private function extendedMethod()
    {
        return 'extended method';
    }
}

class TestClass extends ParentClass
{
    private string $private = 'private property';

    private function method(): string
    {
        return 'private method';
    }
}

beforeEach(function () {
    $this->obj = Reflect::on(new TestClass());
});

it('can read the private property of an object at multiple inheritance levels', function () {
    expect($this->obj->private)->toBe('private property')
        ->and($this->obj->extended)->toBe('extended property')
        ->and($this->obj->grandparent)->toBe('grandparent property');
});

it('can set the private property of an object', function () {
    $this->obj->private = 'private';
    $this->obj->extended = 'extended';
    
    expect($this->obj->private)->toBe('private')
        ->and($this->obj->extended)->toBe('extended');
});

it('can call the private method of an object', function () {
    expect($this->obj->method())->toBe('private method')
        ->and($this->obj->extendedMethod())->toBe('extended method');
});

it('returns an exception for a non-existent property', function () {
    expect(fn () => $this->obj->nonExistentProperty)->toThrow(\ReflectionException::class, "Property 'nonExistentProperty' does not exist.");
});

it('returns an exception for a non-existent method', function () {
    expect(fn () => $this->obj->nonExistentMethod())->toThrow(\ReflectionException::class, "Method 'nonExistentMethod' does not exist.");
});
