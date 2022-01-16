<?php
namespace LoliKillers\RublixDownloader\Model;

use LoliKillers\RublixDownloader\Model\Attribute\TitleAttribute;
use LoliKillers\RublixDownloader\Model\ResourceItem\AudioResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\ImageResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\VideoResourceItem;

/**
 * Class ResourceItem
 * @package LoliKillers\RublixDownloader\Model
 */
abstract class ResourceItem
{
    /**
     * @var URL
     */
    protected $url;

    /**
     * @var URL
     */
    protected $localUrl;

    /**
     * @var TitleAttribute
     */
    protected $title;

    /**
     * @var string
     */
    protected $localPath;

    /**
     * @var callable
     */
    protected $blobCallback;

    /**
     * This needs to exclude callable property ($blobCallback)
     * from serialization
     *
     * @return string[]
     */
    public function __sleep(): array
    {
        return ['url', 'localUrl', 'title', 'localPath'];
    }


    /**
     * @param URL $url
     * @param string $title
     * @return ResourceItem|ImageResourceItem|VideoResourceItem|AudioResourceItem
     */
    public static function fromURL(URL $url, string $title = ''): ResourceItem
    {
        return new static($url, $title);
    }

    /**
     * @return string
     */
    public static function MIMEType(): string
    {
        return static::TYPE . '/' . static::FORMAT;
    }

    /**
     * ResourceItem constructor.
     * @param URL $url
     * @param string $title
     */
    public function __construct(URL $url, string $title = '') {
        $this->url = $url;
        $this->title = new TitleAttribute($title);
        $this->blobCallback = function () {
            return file_get_contents($this->getUrl()->getValue());
        };
    }

    /**
     * @return URL|null
     */
    public function getLocalURL(): ?URL
    {
        return $this->localUrl;
    }

    /**
     * @param URL $url
     */
    public function setLocalURL(URL $url)
    {
        $this->localUrl = $url;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return static::FORMAT;
    }

    /**
     * @return TitleAttribute
     */
    public function getTitle(): TitleAttribute
    {
        return $this->title;
    }

    /**
     * @return URL
     */
    public function getUrl(): URL
    {
        return $this->url;
    }

    /**
     * @param callable $blobCallback
     */
    public function setBlobCallback(callable $blobCallback)
    {
        $this->blobCallback = $blobCallback;
    }

    /**
     * @return callable|\Closure
     */
    public function getBlobCallback()
    {
        return $this->blobCallback;
    }

    /**
     * @return string|null
     */
    public function getLocalPath(): ?string
    {
        return $this->localPath;
    }

    /**
     * @param string $path
     */
    public function setLocalPath(string $path)
    {
        $this->localPath = $path;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'format' => $this->getFormat(),
            'url' => $this->getLocalURL() ? $this->getLocalURL()->getValue() : $this->getUrl()->getValue(),
            'mime_type' => static::MIMEType()
        ] + $this->getTitle()->toArray();
    }
}
