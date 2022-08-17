<?php

declare(strict_types=1);

use App\Rules\Depth;
use Tests\TestCase;

uses(TestCase::class);

it('validates depth of list array', function (): void {
    $rule = new Depth(2);

    expect($rule->passes('attr', []))->toBeTrue()
        ->and($rule->passes('attr', ['foo']))->toBeTrue()
        ->and($rule->passes('attr', ['foo', 'bar']))->toBeTrue()
        ->and($rule->passes('attr', ['foo', ['bar']]))->toBeTrue()
        ->and($rule->passes('attr', ['foo', ['bar', ['baz']]]))->toBeFalse();

    $rule = new Depth(1);
    expect($rule->passes('attr', []))->toBeTrue()
        ->and($rule->passes('attr', ['foo']))->toBeTrue()
        ->and($rule->passes('attr', ['foo', ['bar']]))->toBeFalse()
        ->and($rule->passes('attr', ['foo', ['bar', ['baz']]]))->toBeFalse();
});

it('validates depth of associative array', function (): void {
    $rule = new Depth(2);

    expect($rule->passes('attr', []))->toBeTrue()
        ->and($rule->passes('attr', ['foo' => 'bar']))->toBeTrue()
        ->and($rule->passes('attr', ['foo' => 'bar', 'baz' => 'qux']))->toBeTrue()
        ->and($rule->passes('attr', ['foo' => 'bar', 'baz' => ['qux']]))->toBeTrue()
        ->and($rule->passes('attr', ['foo' => 'bar', 'baz' => ['qux', ['quux']]]))->toBeFalse();
});
