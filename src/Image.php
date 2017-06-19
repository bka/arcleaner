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

    /**
     * getName
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * getTag
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * hasLayer
     *
     * @param string $hash
     * @return bool
     */
    public function hasLayer($hash)
    {
        $layers = $this->manifest->getLayers();
        return array_key_exists($hash, $layers);
    }

    /**
     * getLayerHashes
     * @return array
     */
    public function getLayerHashes()
    {
        return array_keys($this->manifest->getLayers());
    }

    /**
     * getLayer
     *
     * @param string $hash
     * @return \Bka\ARCleaner\Layer
     */
    public function getLayer($hash)
    {
        return $this->manifest->getLayers()[$hash];
    }

    /**
     * getFullName
     * @return string
     */
    public function getFullName()
    {
        return $this->name . ":" . $this->tag;
    }
}
