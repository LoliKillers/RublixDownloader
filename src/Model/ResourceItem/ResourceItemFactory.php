<?php
namespace LoliKillers\RublixDownloader\Model\ResourceItem;

use LoliKillers\RublixDownloader\Model\ResourceItem;
use LoliKillers\RublixDownloader\Model\URL;

/**
 * Class ResourceItemFactory
 * @package LoliKillers\RublixDownloader\Model\ResourceItem
 */
class ResourceItemFactory
{
    /**
     * @var string[]
     */
    private static $resourceItemClasses = [
        ResourceItem\ImageResourceItem::class,
        ResourceItem\Image\JPGResourceItem::class,
        ResourceItem\Image\JPEGResourceItem::class,
        ResourceItem\Image\GIFResourceItem::class,
        ResourceItem\Image\PNGResourceItem::class,
        ResourceItem\Video\MP4ResourceItem::class,
        ResourceItem\Video\WEBMResourceItem::class,
        ResourceItem\Audio\MP3ResourceItem::class,
        ResourceItem\Audio\AudioMP4ResourceItem::class,
        ResourceItem\Text\XMLResourceItem::class,
    ];

    /**
     * @param URL $url
     * @param string $title
     * @return ImageResourceItem|VideoResourceItem|AudioResourceItem
     */
    public static function fromURL(URL $url, string $title = ''): ?ResourceItem
    {
        foreach(self::$resourceItemClasses as $resourceItemClass) {
            if(!defined("$resourceItemClass::FORMAT")) {
                continue;
            }
            /** @var ResourceItem $resourceItemClass */
            if ($resourceItemClass::FORMAT !== $url->fileExt()) {
                continue;
            }
            return $resourceItemClass::fromURL($url, $title);
        }
        return null;
    }

    /**
     * @param URL $url
     * @param string $MIMEType
     * @param string $title
     * @return ImageResourceItem|VideoResourceItem|AudioResourceItem
     */
    public static function fromMimeType(URL $url, string $MIMEType, string $title = ''): ?ResourceItem
    {
        foreach(self::$resourceItemClasses as $resourceItemClass) {
            if(!defined("$resourceItemClass::TYPE")) {
                continue;
            }
            if(!defined("$resourceItemClass::FORMAT")) {
                continue;
            }
            /** @var ResourceItem $resourceItemClass */
            if (strpos($MIMEType, $resourceItemClass::MIMEType()) === false) {
                continue;
            }
            return $resourceItemClass::fromURL($url, $title);
        }
        return null;
    }
}