<?php

namespace RNGenerator;

class PackageDiffer
{
    /**
     * @var array
     */
    private $fromPackageList;

    /**
     * @var array
     */
    private $toPackageList;

    /**
     * PackageDiffer constructor.
     *
     * @param string $fromFile
     * @param string $toFile
     */
    public function __construct($fromFile, $toFile)
    {
        $this->fromPackageList = $this->getPackages($fromFile);
        $this->toPackageList = $this->getPackages($toFile);
    }

    /**
     * @param string $filePath
     *
     * @return mixed
     */
    private function loadPackageContent($filePath)
    {
        $composerLock = json_decode(file_get_contents($filePath));

        return $composerLock->packages;
    }

    /**
     * Loads the packages from a given file.
     *
     * @param string $filePath
     *
     * @return Package[]
     */
    public function getPackages($filePath)
    {
        $packages = [];
        foreach ($this->loadPackageContent($filePath) as $packageContent) {
            $packages[] = new Package(
                $packageContent->name,
                $packageContent->version,
                rtrim($packageContent->source->url, '.git')
            );
        }

        return $packages;
    }

    /**
     * @param Package[] $packageList
     * @param string    $packageName
     *
     * @return null|Package
     */
    private function findPackageInList($packageList, $packageName)
    {
        /** @var Package $packageItem */
        foreach ($packageList as $packageItem) {
            if ($packageItem->getName() == $packageName) {
                return $packageItem;
            }
        }

        return null;
    }

    /**
     * Finds a given package in the FromList.
     *
     * @param string $packageName
     *
     * @return null|Package
     */
    private function findPackageInFromList($packageName)
    {
        return $this->findPackageInList($this->fromPackageList, $packageName);
    }

    /**
     * Finds a given package in the ToList.
     *
     * @param string $packageName
     *
     * @return null|Package
     */
    private function findPackageInToList($packageName)
    {
        return $this->findPackageInList($this->toPackageList, $packageName);
    }

    /**
     * Generates the list of packages newly added.
     *
     * @return Package[]
     */
    public function generateNewPackages()
    {
        $newPackages = [];

        /** @var Package $toPackage */
        foreach ($this->toPackageList as $toPackage) {
            $fromPackage = $this->findPackageInFromList($toPackage->getName());

            if (null === $fromPackage) {
                $newPackages[] = $toPackage;
            }
        }

        return $newPackages;
    }

    /**
     * Generates the list of the packages that have been updated.
     *
     * @return UpdatedPackage[]
     */
    public function generateUpdatedPackages()
    {
        $updatedPackages = [];

        /** @var Package $toPackage */
        foreach ($this->toPackageList as $toPackage) {
            $fromPackage = $this->findPackageInFromList($toPackage->getName());

            if (null !== $fromPackage) {
                if ($fromPackage->getVersion() != $toPackage->getVersion()) {
                    $updatedPackage = new UpdatedPackage(
                        $toPackage,
                        $fromPackage->getVersion()
                    );

                    $updatedPackages[] = $updatedPackage;
                }
            }
        }

        return $updatedPackages;
    }

    /**
     * Generates the list of packages that have been deleted.
     *
     * @return Package[]
     */
    public function generateDeletedPackages()
    {
        $deletedPackages = [];

        /** @var Package $fromPackage */
        foreach ($this->fromPackageList as $fromPackage) {
            $toPackage = $this->findPackageInToList($fromPackage->getName());

            if (null === $toPackage) {
                $deletedPackages[] = $fromPackage;
            }
        }

        return $deletedPackages;
    }
}
