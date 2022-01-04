<?php
namespace LoliKillers\RublixDownloader\Handler\Storage;

use LoliKillers\RublixDownloader\Exception\NotValidUrlException;
use LoliKillers\RublixDownloader\Handler\Storage;
use LoliKillers\RublixDownloader\Model\Attribute\HasResourceItem;
use LoliKillers\RublixDownloader\Model\FetchedResource;
use LoliKillers\RublixDownloader\Model\ResourceItem;
use LoliKillers\RublixDownloader\Model\URL;
use Aws\S3\S3Client;

class S3Storage implements Storage
{
    const ACL_PUBLIC_READ = 'public-read';
    const ACL_PRIVATE = 'private';

    const SERIALIZED_FETCHED_RESOURCE_OBJ_FILE_NAME = 'obj.txt';

    /**
     * @var S3Client
     */
    private $s3Client;

    /**
     * @var string
     */
    private $bucket;

    /**
     * @var string
     */
    private $cdnAlias;

    /**
     * S3Storage constructor.
     * @param S3Client $s3Client
     * @param $bucket
     * @param string $cdnAlias
     */
    public function __construct(S3Client $s3Client, $bucket, $cdnAlias = '')
    {
        $this->s3Client = $s3Client;
        $this->cdnAlias = $cdnAlias;
        $this->bucket = $bucket;
    }

    /**
     * @param URL $url
     * @return FetchedResource|null
     * @throws NotValidUrlException
     */
    public function tryFetchByURL(URL $url): ?FetchedResource
    {
        $objKey = $this->getSerializedDataObjPath($url);
        if (!$this->s3Client->doesObjectExist($this->getBucket(), $objKey)) {
            return null;
        }
        $obj = $this->s3Client->getObject(
            [
                'Bucket' => $this->getBucket(),
                'Key' => $objKey
            ]
        );
        /** @var FetchedResource $fetchedResource */
        $fetchedResource = unserialize($obj['Body']);
        if (!$fetchedResource instanceof FetchedResource) {
            return null;
        }

        $this->mapFetchedResourceLocalPathToUrl($fetchedResource);
        return $fetchedResource;
    }

    /**
     * @param FetchedResource $resource
     * @throws NotValidUrlException
     */
    public function persist(FetchedResource $resource)
    {
        foreach($resource->getItems() as $item) {
            $this->persistItem($item, static::ACL_PUBLIC_READ);

            if ($item === $resource->getPreviewImage()) {
                $resource->getPreviewImage()->setLocalPath($item->getLocalPath());
            }

            if ($item === $resource->getPreviewVideo()) {
                $resource->getPreviewVideo()->setLocalPath($item->getLocalPath());
            }
        }

        if ($resource->getPreviewVideo() instanceof ResourceItem && !$resource->getPreviewVideo()->getLocalPath()) {
            $this->persistItem($resource->getPreviewVideo(), static::ACL_PUBLIC_READ);
        }

        if ($resource->getPreviewImage() instanceof ResourceItem && !$resource->getPreviewImage()->getLocalPath()) {
            $this->persistItem($resource->getPreviewImage(), static::ACL_PUBLIC_READ);
        }

        if (count($resource->getAttributes())) {
            foreach($resource->getAttributes() as $attribute) {
                if (!$attribute instanceof HasResourceItem) {
                    continue;
                }
                if (!$attribute->getResourceItem() instanceof ResourceItem) {
                    continue;
                }
                $this->persistItem($attribute->getResourceItem(), static::ACL_PUBLIC_READ);
            }
        }

        $this->saveSerializedDataObj($resource, static::ACL_PRIVATE);

        $this->mapFetchedResourceLocalPathToUrl($resource);
    }

    /**
     * @param URL $url
     * @return string
     */
    protected function getSerializedDataObjPath(URL $url): string
    {
        return $this->getBasePath($url->getValue()) . static::SERIALIZED_FETCHED_RESOURCE_OBJ_FILE_NAME;
    }

    /**
     * @param FetchedResource $fetchedResource
     * @throws NotValidUrlException
     */
    protected function mapFetchedResourceLocalPathToUrl(FetchedResource $fetchedResource)
    {
        if (count($fetchedResource->getItems()) > 0) {
            foreach ($fetchedResource->getItems() as $item) {
                $item->setLocalURL($this->getObjectURL($item));
            }
        }

        if ($fetchedResource->getPreviewImage() instanceof ResourceItem) {
            $fetchedResource->getPreviewImage()->setLocalURL(
                $this->getObjectUrl($fetchedResource->getPreviewImage())
            );
        }

        if ($fetchedResource->getPreviewVideo() instanceof ResourceItem) {
            $fetchedResource->getPreviewVideo()->setLocalURL(
                $this->getObjectUrl($fetchedResource->getPreviewVideo())
            );
        }

        if (count($fetchedResource->getAttributes())) {
            foreach($fetchedResource->getAttributes() as $attribute) {
                if (!$attribute instanceof HasResourceItem) {
                    continue;
                }
                if (!$attribute->getResourceItem() instanceof ResourceItem) {
                    continue;
                }
                $attribute->getResourceItem()->setLocalURL($this->getObjectURL($attribute->getResourceItem()));
            }
        }
    }

    /**
     * @param ResourceItem $item
     * @return URL
     * @throws NotValidUrlException
     */
    protected function getObjectURL(ResourceItem $item): URL
    {
        if ($this->cdnAlias) {
            return $this->getObjectURLAlias($item->getLocalPath());
        }
        return URL::fromString(
            $this->s3Client->getObjectUrl(
                $this->getBucket(),
                $item->getLocalPath()
            )
        );
    }

    /**
     * @param string $localPath
     * @return URL
     * @throws NotValidUrlException
     */
    protected function getObjectURLAlias(string $localPath): URL
    {
        return URL::fromString($this->cdnAlias . '/' . $localPath);
    }


    /**
     * @param FetchedResource $resource
     * @param $ACL
     */
    protected function saveSerializedDataObj(FetchedResource $resource, $ACL)
    {
        $this->s3Client->putObject([
            'Bucket' => $this->getBucket(),
            'Key'    => $this->getSerializedDataObjPath($resource->getSourceURL()),
            'Body'   => serialize($resource),
            'ACL'    => $ACL,
        ]);
    }

    /**
     * @param ResourceItem $item
     * @param $ACL
     */
    protected function persistItem(ResourceItem $item, $ACL)
    {
        $fileContents = $item->getBlobCallback()();
        $path = $this->getItemFilePath($fileContents, $item);
        $this->s3Client->putObject([
            'Bucket' => $this->getBucket(),
            'Key'    => $path,
            'Body'   => $fileContents,
            'ACL'    => $ACL,
        ]);
        $item->setLocalPath($path);
    }

    /**
     * @param string $fileContents
     * @param ResourceItem $item
     * @return string
     */
    protected function getItemFilePath(string $fileContents, ResourceItem $item): string
    {
        return $item->getType() . '/'
            . $this->getBasePath($fileContents)
            . $this->getItemFileName($item);
    }

    /**
     * @param ResourceItem $item
     * @return string
     */
    protected function getItemFileName(ResourceItem $item): string
    {
        $fileExt = $item->getUrl()->fileExt() ? '' : '.' . $item->getFormat();
        return $item->getUrl()->basenameWithNoQueryParams() . $fileExt;
    }

    /**
     * @return string
     */
    protected function getBucket(): string
    {
        return $this->bucket;
    }

    /**
     * @param string $str
     * @return string
     */
    protected function getBasePath(string $str): string
    {
        return chunk_split($this->getCacheKeyByString($str), 8, '/');
    }

    /**
     * @param string $str
     * @return string
     */
    protected function getCacheKeyByString(string $str): string
    {
        return md5($str);
    }
}
