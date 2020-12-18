<?php

$headerComment = <<<EOF
This file is part of the Xatham/text-extraction package.

(c) Xatham <s.kirejewski@googlemail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->in(__DIR__ . '/examples');

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'ordered_imports' => true,
        'concat_space' => ['spacing' => 'one'],
        'array_syntax' => ['syntax' => 'short'],
        # 'header_comment' => ['header' => $headerComment],
        'yoda_style' => false,
    ])
    ->setFinder($finder);
