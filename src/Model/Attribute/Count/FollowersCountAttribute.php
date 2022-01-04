<?php
namespace LoliKillers\RublixDownloader\Model\Attribute\Count;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class FollowersCountAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute\Count
 */
class FollowersCountAttribute extends Attribute
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
        return 'followers_count';
    }
}