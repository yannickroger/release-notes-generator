<?php

require __DIR__ . '/../vendor/autoload.php';

$fromFilePath = $argv[1];
$toFilePath = $argv[2];

$packageDiffer = new \RNGenerator\PackageDiffer(
    $fromFilePath,
    $toFilePath
);

$renderer = new \RNGenerator\ReleaseNoteRenderer();

echo $renderer->render($packageDiffer);
