<?php

namespace RNGenerator;

class Package
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $url;

    /**
     * Package constructor.
     *
     * @param string $name
     * @param string $version
     * @param string $url
     */
    public function __construct($name, $version, $url)
    {
        $this->name = $name;
        $this->version = $version;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
