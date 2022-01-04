<?php
namespace LoliKillers\RublixDownloader\Model\Attribute;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class TextAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute
 */
class TextAttribute extends Attribute
{

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'text';
    }
}