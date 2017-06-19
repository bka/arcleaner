<?php

namespace Bka\ARCleaner;

/**
 * Class Layer
 */
class Layer
{
    protected $hash;
    protected $size;

    public function __construct($hash, $size)
    {
        $this->hash = $hash;
        $this->size = $size;
    }

    public function getHash()
    {
        return $this->hash;
    }
}
