<?php

namespace RNGenerator;

use Twig_Loader_Filesystem;
use Twig_Environment;

class ReleaseNoteRenderer
{
    /**
     * @var string
     */
    private $templatesPath = './templates';

    /**
     * @var string
     */
    private $templateName = 'standard.md.twig';

    /**
     * ReleaseNoteRenderer constructor.
     *
     * @param string|null $templateName (Optional) if provided the template name to be used to
     *      render the release note.
     */
    public function __construct($templateName = null)
    {
        if ($templateName !== null) {
            $this->templateName = $templateName;
        }
    }

    /**
     * @return string
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->templatesPath;
    }

    /**
     * @param string $templatePath
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatesPath = $templatePath;
    }

    /**
     * Renders a release note using a PackageDiffer.
     *
     * @param PackageDiffer $packageDiffer
     *
     * @return string content of the release note
     */
    public function render(PackageDiffer $packageDiffer)
    {
        $loader = new Twig_Loader_Filesystem($this->templatesPath);
        $twig = new Twig_Environment($loader);
        $template = $twig->load($this->templateName);

        return $template->render(
            [
                'newPackages' => $packageDiffer->generateNewPackages(),
                'updatedPackages' => $packageDiffer->generateUpdatedPackages(),
                'deletedPackages' => $packageDiffer->generateDeletedPackages(),
            ]
        );
    }
}
