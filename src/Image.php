<?php

namespace Bka\ARCleaner;

/**
 * Class Image
 */
class Image
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var Manifest
     */
    protected $manifest;

    /**
     * __construct
     *
     * @param string $name
     * @param string $tag
     * @param Manifest $manifest
     */
    public function __construct($name, $tag, $manifest)
    {
        $this->name = $name;
        $this->tag = $tag;
        $this->manifest = $manifest;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function hasLayer($hash)
    {
        $layers = $this->manifest->getLayers();
        return array_key_exists($hash, $layers);
    }

    public function getLayerHashes()
    {
        return array_keys($this->manifest->getLayers());
    }

    public function getLayer($hash)
    {
        return $this->manifest->getLayers()[$hash];
    }

    public function getFullName()
    {
        return $this->name . ":" . $this->tag;
    }
}
