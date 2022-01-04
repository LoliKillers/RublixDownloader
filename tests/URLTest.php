<?php
namespace LoliKillers\RublikDownloader\Tests;

use LoliKillers\RublikDownloader\Exception\NotValidUrlException;
use LoliKillers\RublikDownloader\Model\URL;
use PHPUnit\Framework\TestCase;

class URLTest extends TestCase
{
    /** @test */
    public function it_creates_obj_from_url_string()
    {
        $url = URL::fromString('http://someurl.com');
        $this->assertInstanceOf(URL::class, $url);
    }

    /** @test */
    public function it_fails_to_create_obj_from_not_url_string()
    {
        $this->expectException(NotValidUrlException::class);
        URL::fromString('heyho');
    }

    /** @test */
    public function it_can_determine_if_url_matches_regex_pattern()
    {
        $url = URL::fromString('https://someurl.com');
        $this->assertTrue($url->matchPattern('/some/'));
    }

    /** @test */
    public function it_fails_to_determine_that_url_matches_regex_pattern()
    {
        $url = URL::fromString('https://someurl.com');
        $this->assertFalse($url->matchPattern('/fail/'));
    }

    /** @test */
    public function url_has_file_ext_eq_jpg()
    {
        $url = URL::fromString('https://someurl.com/somepicture.jpg');
        $this->assertEquals('jpg', $url->fileExt());
    }

    /** @test */
    public function url_with_query_string_has_file_ext_eq_jpg()
    {
        $url = URL::fromString('https://someurl.com/somepicture.jpg?timestamp=20210505123040');
        $this->assertEquals('jpg', $url->fileExt());
    }

    /** @test */
    public function url_has_empty_file_ext()
    {
        $url = URL::fromString('https://someurl.com/path');
        $this->assertEquals('', $url->fileExt());
    }
}