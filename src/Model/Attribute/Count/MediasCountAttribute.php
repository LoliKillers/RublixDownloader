<?php
namespace LoliKillers\RublixDownloader\Model\Attribute\Count;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class MediasCountAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute\Count
 */
class MediasCountAttribute extends Attribute
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
        return 'medias_count';
    }
}