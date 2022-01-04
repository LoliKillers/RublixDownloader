<?php
namespace LoliKillers\RublixDownloader\Model\Attribute;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class IdAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute
 */
class IdAttribute extends Attribute
{

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'id';
    }
}