<?php
namespace LoliKillers\RublixDownloader\Model\Attribute;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class TitleAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute
 */
class TitleAttribute extends Attribute
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
        return 'title';
    }
}