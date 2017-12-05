<?php

namespace spec\RNGenerator;

use RNGenerator\PackageDiffer;
use RNGenerator\ReleaseNoteRenderer;
use PhpSpec\ObjectBehavior;

class ReleaseNoteRendererSpec extends ObjectBehavior
{
    private $customTemplateName = 'custom.md.twig';

    private $defaultTemplateName = 'standard.md.twig';

    private $defaultTemplatePath = './templates';

    private $templatePath = './spec/assets/ReleaseNoteRenderer';

    private $dummyTemplate = 'dummy.md.twig';

    public function it_is_initializable()
    {
        $this->shouldHaveType(ReleaseNoteRenderer::class);
    }

    public function it_has_the_template_name()
    {
        $this->beConstructedWith($this->customTemplateName);

        $this->getTemplateName()->shouldReturn($this->customTemplateName);
    }

    public function it_has_the_default_template_name_if_not_provided()
    {
        $this->getTemplateName()->shouldReturn($this->defaultTemplateName);
    }

    public function it_has_the_templates_path()
    {
        $this->getTemplatePath()->shouldBe($this->defaultTemplatePath);
    }

    public function it_allows_to_set_the_templates_path()
    {
        $path = 'truc';

        $this->setTemplatePath($path);
        $this->getTemplatePath()->shouldBe($path);
    }

    public function it_renders_the_release_note(PackageDiffer $packageDiffer)
    {
        $this->beConstructedWith($this->dummyTemplate);
        $this->setTemplatePath($this->templatePath);

        $packageDiffer->generateNewPackages()->willReturn([]);
        $packageDiffer->generateUpdatedPackages()->willReturn([]);
        $packageDiffer->generateDeletedPackages()->willReturn([]);

        $this->render($packageDiffer)->shouldBeLike('dummy');
    }
}
