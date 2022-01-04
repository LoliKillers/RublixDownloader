<?php
namespace LoliKillers\RublixDownloader;

use LoliKillers\RublixDownloader\Exception\HandlerNotFoundException;
use LoliKillers\RublixDownloader\Exception\NothingToExtractException;
use LoliKillers\RublixDownloader\Exception\NotValidUrlException;
use LoliKillers\RublixDownloader\Model\FetchedResource;
use LoliKillers\RublixDownloader\Model\URL;

interface Downloader
{
    /**
     * @param URL $url
     * @return FetchedResource
     * @throws NothingToExtractException
     * @throws NotValidUrlException
     * @throws HandlerNotFoundException
     */
    public function fetchResource(URL $url): FetchedResource;
}