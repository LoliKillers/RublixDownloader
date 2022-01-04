<?php
namespace LoliKillers\RublixDownloader\Model\Attribute;

use LoliKillers\RublixDownloader\Model\Attribute;
use LoliKillers\RublixDownloader\Model\AttributesAggregate;
use LoliKillers\RublixDownloader\Model\ResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\ImageResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\ResourceItemFactory;
use LoliKillers\RublixDownloader\Model\URL;

/**
 * Class AuthorAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute
 */
class AuthorAttribute extends Attribute implements HasResourceItem, AttributesAggregate
{
    /**
     * @var IdAttribute
     */
    protected $id;

    /**
     * @var URL|null
     */
    protected $avatarUrl;

    /**
     * @var ResourceItem|ImageResourceItem
     */
    protected $avatarResourceItem;

    /**
     * @var string $fullname
     */
    protected $fullName;

    /**
     * @var string $nickname
     */
    protected $nickname;

    /**
     * @var Attribute[] $attributes
     */
    protected $attributes = [];

    /**
     * @return IdAttribute
     */
    public function getId(): IdAttribute
    {
        return $this->id;
    }

    /**
     * @return URL|null
     */
    public function getAvatarUrl(): ?URL
    {
        return $this->avatarUrl;
    }

    /**
     * @return mixed
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @return mixed
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param Attribute $attr
     */
    public function addAttribute(Attribute $attr)
    {
        $this->attributes[$attr->getKey()] = $attr;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'author';
    }

    /**
     * @return ResourceItem|null
     */
    public function getResourceItem(): ?ResourceItem
    {
        return $this->avatarResourceItem;
    }

    /**
     * AuthorAttribute constructor.
     * @param string $id
     * @param string $nickname
     * @param string $fullName
     * @param URL|null $avatarUrl
     */
    public function __construct(string $id = '', string $nickname = '', string $fullName = '', URL $avatarUrl = null)
    {
        $this->id = new IdAttribute($id);
        $this->nickname = $nickname;
        $this->fullName = $fullName;
        $this->avatarUrl = $avatarUrl;

        if ($avatarUrl instanceof URL) {
            $this->avatarResourceItem = ResourceItemFactory::fromURL($avatarUrl);
        }

        parent::__construct([
            'id' => $id,
            'avatar_url' => $avatarUrl,
            'full_name' => $fullName,
            'nickname' => $nickname,
            'avatar' => $this->avatarResourceItem
        ]);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->getKey() =>
                $this->id->toArray() + [
                    'avatar_url' => $this->avatarUrl ? $this->avatarUrl->getValue() : null,
                    'full_name' => $this->fullName,
                    'nickname' => $this->nickname,
                    'avatar' => $this->avatarResourceItem ? $this->avatarResourceItem->toArray() : null
                ] + $this->attributesToArray()
        ];
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