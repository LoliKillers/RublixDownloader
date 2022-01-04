<?php
namespace LoliKillers\RublixDownloader\Tests;

use LoliKillers\RublixDownloader\Model\ResourceItem\Audio\MP3ResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\Image\GIFResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\Image\JPEGResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\Image\JPGResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\Image\PNGResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\ResourceItemFactory;
use LoliKillers\RublixDownloader\Model\ResourceItem\Video\MP4ResourceItem;
use LoliKillers\RublixDownloader\Model\ResourceItem\Video\WEBMResourceItem;
use LoliKillers\RublixDownloader\Model\URL;
use PHPUnit\Framework\TestCase;

class ResourceItemFactoryTest extends TestCase
{
    /** @test */
    public function it_creates_jpg_resource_by_url()
    {
        $url = URL::fromString('https://someurl.com/somepath/image.jpg?ts=222222');
        $resource = ResourceItemFactory::fromURL($url);
        $this->assertInstanceOf(JPGResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_jpeg_resource_by_url()
    {
        $url = URL::fromString('https://someurl.com/somepath/image.jpeg?ts=222222');
        $resource = ResourceItemFactory::fromURL($url);
        $this->assertInstanceOf(JPEGResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_gif_resource_by_url()
    {
        $url = URL::fromString('https://someurl.com/somepath/image.gif?ts=222222');
        $resource = ResourceItemFactory::fromURL($url);
        $this->assertInstanceOf(GIFResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_png_resource_by_url()
    {
        $url = URL::fromString('https://someurl.com/somepath/image.png?ts=222222');
        $resource = ResourceItemFactory::fromURL($url);
        $this->assertInstanceOf(PNGResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_mp4_resource_by_url()
    {
        $url = URL::fromString('https://someurl.com/somepath/video.mp4?ts=222222');
        $resource = ResourceItemFactory::fromURL($url);
        $this->assertInstanceOf(MP4ResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_webm_resource_by_url()
    {
        $url = URL::fromString('https://someurl.com/somepath/video.webm?ts=222222');
        $resource = ResourceItemFactory::fromURL($url);
        $this->assertInstanceOf(WEBMResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_mp3_resource_by_url()
    {
        $url = URL::fromString('https://someurl.com/somepath/audio.mp3?ts=222222');
        $resource = ResourceItemFactory::fromURL($url);
        $this->assertInstanceOf(MP3ResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_jpg_resource_by_mimetype()
    {
        $url = URL::fromString('https://someurl.com/somepath/image');
        $resource = ResourceItemFactory::fromMimeType($url, 'image/jpg');
        $this->assertInstanceOf(JPGResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_jpeg_resource_by_mimetype()
    {
        $url = URL::fromString('https://someurl.com/somepath/image');
        $resource = ResourceItemFactory::fromMimeType($url, 'image/jpeg');
        $this->assertInstanceOf(JPEGResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_gif_resource_by_mimetype()
    {
        $url = URL::fromString('https://someurl.com/somepath/image');
        $resource = ResourceItemFactory::fromMimeType($url, 'image/gif');
        $this->assertInstanceOf(GIFResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_png_resource_by_mimetype()
    {
        $url = URL::fromString('https://someurl.com/somepath/image');
        $resource = ResourceItemFactory::fromMimeType($url, 'image/png');
        $this->assertInstanceOf(PNGResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_mp4_resource_by_mimetype()
    {
        $url = URL::fromString('https://someurl.com/somepath/video');
        $resource = ResourceItemFactory::fromMimeType($url, 'video/mp4');
        $this->assertInstanceOf(MP4ResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_webm_resource_by_mimetype()
    {
        $url = URL::fromString('https://someurl.com/somepath/image');
        $resource = ResourceItemFactory::fromMimeType($url, 'video/webm');
        $this->assertInstanceOf(WEBMResourceItem::class, $resource);
    }

    /** @test */
    public function it_creates_mp3_resource_by_mimetype()
    {
        $url = URL::fromString('https://someurl.com/somepath/audio');
        $resource = ResourceItemFactory::fromMimeType($url, 'audio/mp3');
        $this->assertInstanceOf(MP3ResourceItem::class, $resource);
    }
}