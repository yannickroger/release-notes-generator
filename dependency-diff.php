<?php

function parseFile ($filePath) {
    $fileContent = file_get_contents($filePath);
    $json = json_decode($fileContent);
    return $json;
}

function getPackage ($packageList, $packageName) {
    foreach ($packageList as $packageItem) {
        if ($packageItem->name == $packageName) {
            return $packageItem;
        }
    }

    return null;
}

function findNewOrUpdated ($oldPackageList, $newPackageList) {
    foreach ($newPackageList as $newPackage) {
        $oldPackage = getPackage($oldPackageList, $newPackage->name);

        if ($oldPackage === null){
            printNew( $newPackage );
        } else {
            if ($oldPackage->version != $newPackage->version) {
                printUpdated($oldPackage, $newPackage);
            }
        }
    }
}

function findDeleted ($oldPackageList, $newPackageList) {
    foreach ($oldPackageList as $oldPackage) {
        $newPackage = getPackage($newPackageList, $oldPackage->name);

        if ($newPackage === null) {
            printDeleted($oldPackage);
        }
    }
}

function printUpdated ($oldPackage, $newPackage) {
    $versionDiff = $oldPackage->version . ".." . $newPackage->version;
    $url = rtrim($newPackage->source->url, ".git") . "/compare/" .$versionDiff;

    echo "|" . $newPackage->name . " | [" . $versionDiff . "](" . $url . ")|\n";
}

function printNew ($newPackage) {
    echo "|" . $newPackage->name . " | Newly added|\n";
}

function printDeleted ($package) {
    echo "|" . $package->name . " | Deleted|\n";
}

$oldPackages = parseFile($argv[1])->packages;
$newPackages = parseFile($argv[2])->packages;


findNewOrUpdated($oldPackages, $newPackages);
findDeleted($oldPackages, $newPackages);


