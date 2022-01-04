<?php
namespace LoliKillers\RublixDownloader\Model\Attribute\Count;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class FollowingCountAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute\Count
 */
class FollowingCountAttribute extends Attribute
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
        return 'following_count';
    }
}