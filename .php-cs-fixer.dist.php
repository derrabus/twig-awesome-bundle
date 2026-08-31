<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = new Finder()
    ->in([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->append([__FILE__])
;

return new Config()
    ->setFinder($finder)
    ->setUsingCache(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP8x4Migration' => true,
        '@PHP8x4Migration:risky' => true,
        '@PHPUnit11x0Migration:risky' => true,

        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['imports_order' => ['class', 'const', 'function']],
        'method_chaining_indentation' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
        'phpdoc_order' => true,
        'visibility_required' => ['elements' => ['property', 'method', 'const']],
    ])
    ->setRiskyAllowed(true)
;
