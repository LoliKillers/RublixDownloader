<?php
namespace LoliKillers\RublixDownloader\Model\Attribute\Count;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class CommentsCountAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute\Count
 */
class CommentsCountAttribute extends Attribute
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
        return 'comments_count';
    }
}