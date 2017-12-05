<?php

namespace spec\RNGenerator;

use RNGenerator\Package;
use PhpSpec\ObjectBehavior;

class PackageSpec extends ObjectBehavior
{
    private $name;
    private $version;
    private $url;

    public function let()
    {
        $this->beConstructedWith($this->name, $this->version, $this->url);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Package::class);
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldReturn($this->name);
    }

    public function it_has_a_version()
    {
        $this->getVersion()->shouldReturn($this->version);
    }

    public function it_has_a_url()
    {
        $this->getUrl()->shouldReturn($this->url);
    }
}
