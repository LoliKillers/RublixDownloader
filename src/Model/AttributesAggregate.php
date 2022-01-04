<?php
namespace AnyDownloader\RublixDownloader\Model;

/**
 * Interface AttributesAggregate
 * @package LoliKillers\RublixDownloader\Model
 */
interface AttributesAggregate
{
    /**
     * @param Attribute $attr
     * @return mixed
     */
    public function addAttribute(Attribute $attr);

    /**
     * @return Attribute[]
     */
    public function getAttributes(): array;
}