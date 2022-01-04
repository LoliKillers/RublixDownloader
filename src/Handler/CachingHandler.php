<?php
namespace LoliKillers\RublixDownloader\Handler;

use LoliKillers\RublixDownloader\Exception\NothingToExtractException;
use LoliKillers\RublixDownloader\Exception\NotValidUrlException;
use LoliKillers\RublixDownloader\Handler;
use LoliKillers\RublixDownloader\Model\FetchedResource;
use LoliKillers\RublixDownloader\Model\URL;

/**
 * Class CachingHandler
 * @package LoliKillers\RublixDownloader\Handler
 */
class CachingHandler implements Handler
{
    /**
     * @var CachingHandler
     */
    private $handler;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * CachingHandler constructor.
     * @param BaseHandler $handler
     * @param Storage $storage
     */
    public function __construct(BaseHandler $handler, Storage $storage)
    {
        $this->handler = $handler;
        $this->storage = $storage;
    }

    /**
     * @param URL $url
     * @return FetchedResource
     * @throws NotValidUrlException
     * @throws NothingToExtractException
     */
    public function fetchResource(URL $url): FetchedResource
    {
        if (!$resource = $this->storage->tryFetchByURL($url)) {
            $resource = $this->handler->fetchResource($url);
            $this->storage->persist($resource);
        }
        return $resource;
    }

    /**
     * @param URL $url
     * @return bool
     */
    public function isValidUrl(URL $url): bool
    {
        return $this->handler->isValidUrl($url);
    }
}