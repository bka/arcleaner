<?php

namespace Bka\ARCleaner;

use Bka\ARCleaner\Context;
use Bka\ARCleaner\Manifest;

/**
 * Class Client
 * @author Bernhard Leers
 */
class Client
{
    /**
     * @var Bka\ARCleaner\Context
     */
    protected $context;

    /**
     * __construct
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function getImages()
    {
        $result = [];

        $blobList = $this->context->getClient()->listBlobs($this->context->getRepository());
        $blobs = $blobList->getBlobs();

        foreach ($blobs as $blob) {
            if (strpos($blob->getName(), "_manifests/tags") && !strpos($blob->getName(), "current")) {
                $out = [];
                preg_match("/(\/docker\/registry\/v2\/repositories\/)(\w*)\/_manifests\/tags\/([a-zA-Z0-9\.]*)\//", $blob->getName(), $out);
                $imageName = $out[2];
                $tag = $out[3];

                $layerHash = $this->readBlob($blob->getName());
                $path = $this->convertHashToBlobPath($layerHash);
                $manifestJson = $this->readBlob($path) . "\n";
                $manifest = new Manifest($manifestJson);
                $result[] = new Image($imageName, $tag, $manifest);
            }
        }
        return $result;
    }

    public function getBlobsToDeleteForImage($imageName, $tag)
    {
        $names = [];
        $blobList = $this->context->getClient()->listBlobs($this->context->getRepository());
        $blobs = $blobList->getBlobs();
        foreach ($blobs as $blob) {
            if (strpos($blob->getName(), "_manifests/tags") && strpos($blob->getName(), $tag) && strpos($blob->getName(), $imageName)) {
                $names[] = $blob->getName();
                $out = [];
                preg_match("/(\/docker\/registry\/v2\/repositories\/)(\w*)\/_manifests\/tags\/([a-zA-Z0-9\.]*)\//", $blob->getName(), $out);
                $imageName = $out[2];
                $hash = $this->readBlob($blob->getName());
                $path = $this->convertHashToManifestPath($imageName, $hash);
                $names[] = $path;
            }
        }
        return array_unique($names);
    }

    public function readBlob($name)
    {
        $getBlobResult = $this->context->getClient()->getBlob($this->context->getRepository(), $name);
        return stream_get_contents($getBlobResult->getContentStream());
    }

    public function convertHashToBlobPath($hash)
    {
        $hash = str_replace("sha256:", "", $hash);
        $prefix = substr($hash, 0, 2);
        $path = "/docker/registry/v2/blobs/sha256/" . $prefix . "/" . str_replace(":", "/", $hash) . "/data";
        return $path;
    }

    public function convertHashToManifestPath($imageName, $hash)
    {
        $hash = str_replace("sha256:", "", $hash);
        $prefix = substr($hash, 0, 2);
        $path = "/docker/registry/v2/".$imageName."/_manifests/revisions/sha256/" . $hash . "/link";
        return $path;
    }
}
