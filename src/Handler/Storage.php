<?php
namespace LoliKillers\RublixDownloader\Handler;

use LoliKillers\RublixDownloader\Handler;
use LoliKillers\RublixDownloader\Model\FetchedResource;
use LoliKillers\RublixDownloader\Model\URL;

/**
 * Interface Storage
 * @package LoliKillers\RublixDownloader\Handler
 */
interface Storage
{
    /**
     * @param URL $url
     * @return FetchedResource|null
     */
    public function tryFetchByURL(URL $url): ?FetchedResource;

    /**
     * @param FetchedResource $resource
     * @return void
     */
    public function persist(FetchedResource $resource);
}