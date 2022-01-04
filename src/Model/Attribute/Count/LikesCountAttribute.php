<?php
namespace LoliKillers\RublixDownloader\Model\Attribute\Count;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class LikesCountAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute\Count
 */
class LikesCountAttribute extends Attribute
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
        return 'likes_count';
    }
}