<?php

namespace RNGenerator;

class UpdatedPackage extends Package
{
    /**
     * @var string
     */
    private $previousVersion;

    /**
     * UpdatedPackage constructor.
     *
     * @param Package $package
     * @param string $previousVersion
     */
    public function __construct(Package $package, $previousVersion)
    {
        parent::__construct(
            $package->getName(),
            $package->getVersion(),
            $package->getUrl()
        );

        $this->previousVersion = $previousVersion;
    }

    /**
     * @return string
     */
    public function getPreviousVersion()
    {
        return $this->previousVersion;
    }
}
