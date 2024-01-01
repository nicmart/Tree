<?php

/**
 * Copyright (c) 2013-2024 Nicolò Martini
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/nicmart/Tree
 */

use Ergebnis\License;
use Ergebnis\PhpCsFixer;

$license = License\Type\MIT::markdown(
    __DIR__ . '/LICENSE.md',
    License\Range::since(
        License\Year::fromString('2013'),
        new \DateTimeZone('UTC'),
    ),
    License\Holder::fromString('Nicolò Martini'),
    License\Url::fromString('https://github.com/nicmart/Tree'),
);

$license->save();

$ruleSet = PhpCsFixer\Config\RuleSet\Php80::create()
    ->withHeader($license->header())
    ->withRules(PhpCsFixer\Config\Rules::fromArray([
        'declare_strict_types' => false,
        'final_class' => false,
        'void_return' => false,
    ]));

$config = PhpCsFixer\Config\Factory::fromRuleSet($ruleSet);

$config->getFinder()
    ->ignoreDotFiles(false)
    ->in(__DIR__)
    ->exclude([
        '.build/',
        '.github/',
    ])
    ->name('.php-cs-fixer.php');

$config->setCacheFile(__DIR__ . '/.build/php-cs-fixer/.php-cs-fixer.cache');

return $config;
