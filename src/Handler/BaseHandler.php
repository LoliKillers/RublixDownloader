<?php
namespace LoliKillers\RublixDownloader\Handler;

use LoliKillers\RublixDownloader\Exception\NothingToExtractException;
use LoliKillers\RublixDownloader\Exception\NotValidUrlException;
use LoliKillers\RublixDownloader\Handler;
use LoliKillers\RublixDownloader\Model\FetchedResource;
use LoliKillers\RublixDownloader\Model\URL;

/**
 * Class BaseHandler
 * @package LoliKillers\RublixDownloader\Handler
 */
abstract class BaseHandler implements Handler
{
    /**
     * @var string[]
     */
    protected $urlIncludes = [];

    /**
     * @var string[]
     */
    protected $urlRegExPatterns = [];

    /**
     * @param URL $url
     * @return bool
     */
    public function isValidUrl(URL $url): bool
    {
        if (!empty($this->urlIncludes)) {
            foreach ($this->urlIncludes as $subUrl) {
                if ($url->includes($subUrl)) {
                    return true;
                }
            }
        }

        if (!empty($this->urlRegExPatterns)) {
            foreach ($this->urlRegExPatterns as $pattern) {
                if ($url->matchPattern($pattern)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param URL $url
     * @return FetchedResource
     * @throws NothingToExtractException
     * @throws NotValidUrlException
     */
    abstract function fetchResource(URL $url): FetchedResource;
}