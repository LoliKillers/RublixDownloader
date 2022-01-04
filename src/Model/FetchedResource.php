<?php
namespace LoliKillers\RublixDownloader\Model;

use LoliKillers\RublixDownloader\Model\ResourceItem\ImageResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\VideoResourceItem;
use LoliKillers\RublixDownloader\Model\URL;

/**
 * Class FetchedResource
 * @package LoliKillers\RublixDownloader\Model
 */
abstract class FetchedResource implements AttributesAggregate
{
    /**
     * @var URL
     */
    protected $sourceUrl;

    /**
     * @var ImageResourceItem
     */
    protected $previewImage;

    /**
     * @var VideoResourceItem
     */
    protected $previewVideo;

    /**
     * @var ResourceItem[]
     */
    protected $items = [];

    /**
     * @var Attribute[]
     */
    protected $attributes = [];

    /**
     * FetchedResource constructor.
     * @param URL $sourceUrl
     */
    public function __construct(URL $sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;
    }

    /**
     * @return string
     */
    abstract public function getExtSource(): string;

    /**
     * @return URL
     */
    public function getSourceURL(): URL
    {
        return $this->sourceUrl;
    }

    /**
     * @param ImageResourceItem $item
     */
    public function setImagePreview(ImageResourceItem $item)
    {
        $this->previewImage = $item;
    }

    /**
     * @param VideoResourceItem $item
     */
    public function setVideoPreview(VideoResourceItem $item)
    {
        $this->previewVideo = $item;
    }

    /**
     * @param ResourceItem $item
     */
    public function addItem(ResourceItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @param Attribute $attr
     */
    public function addAttribute(Attribute $attr)
    {
        $this->attributes[$attr->getKey()] = $attr;
    }

    /**
     * @return ImageResourceItem
     */
    public function getPreviewImage(): ?ImageResourceItem
    {
        return $this->previewImage;
    }

    /**
     * @return VideoResourceItem
     */
    public function getPreviewVideo(): ?VideoResourceItem
    {
        return $this->previewVideo;
    }

    /**
     * @return ResourceItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return Attribute[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ext_source' => $this->getExtSource(),
            'source_url' => $this->sourceUrl->getValue(),
            'preview_image' => $this->getPreviewImage() ? $this->getPreviewImage()->toArray() : null,
            'preview_video' => $this->getPreviewVideo() ? $this->getPreviewVideo()->toArray() : null,
            'attributes' => $this->attributesToArray(),
            'items' => $this->itemsToArray()
        ];
    }

    /**
     * @return array
     */
    protected function itemsToArray(): array
    {
        $items = [];
        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                $items[$item->getType()][] = $item->toArray();
            }
        }
        return $items;
    }

    /**
     * @return array
     */
    protected function attributesToArray(): array
    {
        $attributes = [];
        if (!empty($this->attributes)) {
            foreach ($this->attributes as $attribute) {
                $attributes += $attribute->toArray();
            }
        }
        return $attributes;
    }
}