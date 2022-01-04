<?php
namespace LoliKillers\RublixDownloader\Model\Attribute;

use LoliKillers\RublixDownloader\Model\ResourceItem;

interface HasResourceItem
{
    /**
     * @return ResourceItem|null
     */
    public function getResourceItem(): ?ResourceItem;
}
