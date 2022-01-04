<?php
namespace LoliKillers\RublixDownloader\Model;

use LoliKillers\RublixDownloader\Exception\NotValidUrlException;

/**
 * Class URL
 * @package LoliKillers\RublixDownloader\Model
 */
class URL
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $substr
     * @return bool
     */
    public function includes(string $substr): bool
    {
        if (stripos($this->value, $substr) !== false) {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function basename(): string
    {
        return basename($this->getValue());
    }

    /**
     * @return string
     */
    public function basenameWithNoQueryParams(): string
    {
        return basename(explode('?', $this->getValue())[0]);
    }

    /**
     * @return string
     */
    public function fileExt(): string
    {
        return pathinfo(parse_url($this->getValue(), PHP_URL_PATH), PATHINFO_EXTENSION);
    }

    /**
     * @param string $regEx
     * @return bool
     */
    public function matchPattern(string $regEx): bool
    {
        return (bool) preg_match($regEx, $this->getValue());
    }

    /**
     * URL constructor.
     * @param string $value
     */
    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $url
     * @return static
     * @throws NotValidUrlException
     */
    public static function fromString(string $url): self
    {
        if (
            stripos($url, 'http://') !== 0
            && stripos($url, 'https://') !== 0
            && stripos($url, '//') !== 0
        ) {
            throw new NotValidUrlException();
        }

        return new static($url);
    }

    /**
     * @param int $redirectsLeft
     */
    public function followLocation(int $redirectsLeft = 5): void
    {
        if ($redirectsLeft == 0) {
            return;
        }
        $context = stream_context_create(['http' => ['method' => 'HEAD']]);
        $respHeaders = get_headers($this->getValue(), true, $context);
        foreach ($respHeaders as $header => $value) {
            if (strtolower($header) === 'location') {
                $this->value = is_array($value) ? $value[0] : $value;
                $this->followLocation(--$redirectsLeft);
            }
        }
    }
}