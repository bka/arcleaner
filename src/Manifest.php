<?php

namespace Bka\ARCleaner;

use Bka\ARCleaner\Layer;

/**
 * Class Manifest
 */
class Manifest
{
    protected $layers = [];

    public function __construct($jsonString)
    {
        $data = json_decode($jsonString, true);
        foreach ($data['layers'] as $layerData) {
            $layer = new Layer($layerData['digest'], $layerData['size']);
            $this->layers[$layerData['digest']] = $layer;
        }
    }

    public function getLayers()
    {
        return $this->layers;
    }
}
