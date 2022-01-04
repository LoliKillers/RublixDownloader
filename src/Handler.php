<?php
namespace LoliKillers\RublixDownloader;

use LoliKillers\RublixDownloader\Model\URL;

interface Handler extends Downloader
{
    /**
     * @param URL $url
     * @return bool
     */
    public function isValidUrl(URL $url): bool;
}