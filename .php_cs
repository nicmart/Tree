<?php

use Ergebnis\PhpCsFixer;
use PhpCsFixer\Fixer;

$header = <<<'TXT'
This file is part of Tree.

(c) 2013 Nicolò Martini

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
TXT;

$config = PhpCsFixer\Config\Factory::fromRuleSet(new PhpCsFixer\Config\RuleSet\Php71(), [
    'declare_strict_types' => false,
    'final_class' => false,
    'header_comment' => [
        'comment_type' => Fixer\Comment\HeaderCommentFixer::HEADER_COMMENT,
        'header' => \trim($header),
        'location' => 'after_declare_strict',
        'separate' => 'both',
    ],
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
