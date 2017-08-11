<?php

namespace spec\RNGenerator;

use RNGenerator\Package;
use RNGenerator\PackageDiffer;
use PhpSpec\ObjectBehavior;
use RNGenerator\UpdatedPackage;

class PackageDifferSpec extends ObjectBehavior
{
    private $loaderFilePath = 'spec/assets/PackageDiffer/loader.json';
    private $fromFile = 'spec/assets/PackageDiffer/fromFile.json';
    private $toFile = 'spec/assets/PackageDiffer/toFile.json';

    function let()
    {
        $this->beConstructedWith($this->fromFile, $this->toFile);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PackageDiffer::class);
    }

    function it_loads_packages_from_file()
    {
        $packages = $this->getPackages($this->loaderFilePath);

        $packages->shouldBeArray();
        $packages->shouldHaveCount(2);

        $trimedUrl = 'https://github.com/update1';

        /** @var Package $package */
        $package = $packages[0];
        $package->getUrl()->shouldBe($trimedUrl);
    }

    function it_generates_the_list_of_new_packages()
    {
        $newPackages = $this->generateNewPackages();

        $newPackages->shouldBeArray();
        $newPackages->shouldHaveCount(1);

        /** @var Package $updatedPackage */
        $newPackage = $newPackages[0];
        $newPackage->getName()->shouldBe('new');
    }

    function it_generates_the_list_of_updated_packages()
    {
        $updatedPackages = $this->generateUpdatedPackages();

        $updatedPackages->shouldBeArray();
        $updatedPackages->shouldHaveCount(1);

        /** @var UpdatedPackage $updatedPackage */
        $updatedPackage = $updatedPackages[0];
        $updatedPackage->getName()->shouldBe('updated');
        $updatedPackage->getVersion()->shouldBe('4');
        $updatedPackage->getPreviousVersion()->shouldBe('3');
    }

    function it_generates_the_list_of_deleted_packages()
    {
        $deletedPackages = $this->generateDeletedPackages();

        $deletedPackages->shouldBeArray();
        $deletedPackages->shouldHaveCount(1);

        /** @var Package $deletedPackage */
        $deletedPackage = $deletedPackages[0];
        $deletedPackage->getName()->shouldBe('deleted');
    }
}
