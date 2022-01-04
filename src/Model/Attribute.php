<?php
namespace LoliKillers\RublixDownloader\Model;

/**
 * Class Attribute
 * @package LoliKillers\RublixDownloader\Model
 */
abstract class Attribute
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @return mixed
     */
    abstract public function getKey(): string;

    /**
     * Attribute constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->getKey() => $this->getValue()
        ];
    }
}