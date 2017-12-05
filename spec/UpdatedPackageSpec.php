<?php

namespace spec\RNGenerator;

use RNGenerator\Package;
use RNGenerator\UpdatedPackage;
use PhpSpec\ObjectBehavior;

class UpdatedPackageSpec extends ObjectBehavior
{
    public function let()
    {
        $package = new Package('truc', '12', 'http://truc.com');
        $this->beConstructedWith($package, '10');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UpdatedPackage::class);
    }

    public function it_has_previous_version()
    {
        $this->getPreviousVersion()->shouldBe('10');
    }
}
