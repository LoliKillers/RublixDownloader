<?php
namespace LoliKillers\RublixDownloader\Model\Attribute\Count;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class VideosCountAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute\Count
 */
class VideosCountAttribute extends Attribute
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'videos_count';
    }
}