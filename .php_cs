<?php

/*
 * This file is part of Tree.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Ergebnis\License;
use Ergebnis\PhpCsFixer;

$license = License\Type\MIT::text(
    __DIR__ . '/LICENSE',
    License\Range::since(
        License\Year::fromString('2013'),
        new \DateTimeZone('UTC')
    ),
    License\Holder::fromString('Nicolò Martini'),
    License\Url::fromString('https://github.com/nicmart/Tree')
);

$license->save();

$config = PhpCsFixer\Config\Factory::fromRuleSet(new PhpCsFixer\Config\RuleSet\Php71($license->header()), [
    'declare_strict_types' => false,
    'final_class' => false,
    'void_return' => false,
]);

$config->getFinder()
    ->ignoreDotFiles(false)
    ->in(__DIR__)
    ->exclude([
        '.build/',
        '.github/',
    ])
    ->name('.php_cs');

$config->setCacheFile(__DIR__ . '/.build/php-cs-fixer/.php_cs.cache');

return $config;
