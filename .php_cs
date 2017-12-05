<?php
return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([__DIR__ . '/src', __DIR__ . '/spec', __DIR__ . '/bin'])
            ->exclude([
                'docs',
                'vendor',
            ])
            ->files()->name('*.php')
    )
;
