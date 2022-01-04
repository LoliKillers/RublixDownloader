<?php
namespace LoliKillers\RublixDownloader\Model\Attribute\Count;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class PhotosCountAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute\Count
 */
class PhotosCountAttribute extends Attribute
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
        return 'photos_count';
    }
}