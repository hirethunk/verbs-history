<?php

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Thunk\VerbsHistory\Tests\TestCase;

$examples = collect(Finder::create()->directories()->in(__DIR__.'/../examples/')->depth(1)->name('tests'))
    ->map(fn (SplFileInfo $file) => $file->getRealPath())
    ->values()
    ->all();

expect()->extend('toThrow', function (string|Throwable $expected, ?string $message = null) {
    if ($expected instanceof Throwable) {
        $message = $expected->getMessage();
        $expected = $expected::class;
    }

    if (! $this->value instanceof Closure) {
        throw new InvalidArgumentException('toHaveThrown must be passed a closure');
    }

    try {
        call_user_func($this->value);
    } catch (Throwable $e) {
        $message ??= $e->getMessage();
        if ($e instanceof $expected && $message === $e->getMessage()) {
            return true;
        }
    }

    return false;
});

uses(TestCase::class)
    ->in(__DIR__, ...$examples);
