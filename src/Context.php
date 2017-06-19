<?php

namespace Bka\ARCleaner;

use MicrosoftAzure\Storage\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

/**
 * Class Context
 */
class Context
{

    /**
     * @var \MicrosoftAzure\Storage\Blob\BlobRestProxy
     */
    public $client;

    /**
     * @var string
     */
    public $repository;

    /**
     * __construct
     *
     * @param \MicrosoftAzure\Storage\Blob\BlobRestProxy $blobClient
     * @param string $repository
     */
    public function __construct(
        $accountName,
        $accountKey,
        $repository
    ) {
        $connectionString = "DefaultEndpointsProtocol=https;AccountName=".$accountName.";AccountKey=".$accountKey;
        $this->blobClient = ServicesBuilder::getInstance()->createBlobService($connectionString);
        $this->repository = $repository;
    }

    /**
     * getClient
     * @return \MicrosoftAzure\Storage\Blob\BlobRestProxy
     *
     */
    public function getClient()
    {
        return $this->blobClient;
    }

    /**
     * getRepository
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

}
