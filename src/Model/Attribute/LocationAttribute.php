<?php
namespace LoliKillers\RublixDownloader\Model\Attribute;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class LocationAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute
 */
class LocationAttribute extends Attribute
{

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'location';
    }
}