<?php

namespace Bka\ARCleaner;

/**
 * Class Layer
 */
class Layer
{
    /**
     * @var string
     */
    protected $hash;

    /**
     * @var int
     */
    protected $size;

    /**
     * __construct
     *
     * @param mixed $hash
     * @param mixed $size
     */
    public function __construct($hash, $size)
    {
        $this->hash = $hash;
        $this->size = $size;
    }

    /**
     * getHash
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
}
