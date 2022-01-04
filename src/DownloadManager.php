<?php
namespace LoliKillers\RublixDownloader;

use LoliKillers\RublixDownloader\Exception\HandlerNotFoundException;
use LoliKillers\RublixDownloader\Model\FetchedResource;
use LoliKillers\RublixDownloader\Model\URL;

final class RublixDownloader implements Downloader
{
    /**
     * @var Handler[]
     */
    private $handlersRegistry;


    /**
     * @param URL $url
     * @return FetchedResource
     * @throws Exception\NotValidUrlException
     * @throws Exception\NothingToExtractException
     * @throws Exception\HandlerNotFoundException
     */
    public function fetchResource(URL $url): FetchedResource
    {
        foreach($this->handlersRegistry as $handler) {
            if ($handler->isValidUrl($url)) {
                return $handler->fetchResource($url);
            }
        }
        throw new HandlerNotFoundException();
    }

    /**
     * @param Handler $handler
     */
    public function addHandler(Handler $handler)
    {
        $this->handlersRegistry[] = $handler;
    }

}