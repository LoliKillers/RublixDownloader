<?php
namespace LoliKillers\RublixDownloader\Model\Attribute;

use LoliKillers\RublixDownloader\Model\Attribute;

/**
 * Class HashtagsAttribute
 * @package LoliKillers\RublixDownloader\Model\Attribute
 */
class HashtagsAttribute extends Attribute
{
    /**
     * @var string[]
     */
    protected $value;


    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'hashtags';
    }

    /**
     * @param string $hashtags
     * @return HashtagsAttribute
     */
    public static function fromStringWithComaDelimiter(string $hashtags): HashtagsAttribute
    {
        if (empty($hashtags)) {
            return new self($hashtags);
        }

        $hashtags = explode(',', $hashtags);
        foreach ($hashtags as $i => $hashtag ) {
            $hashtag = trim($hashtag);
            if (empty($hashtag)) {
                unset($hashtags[$i]);
            } else {
                $hashtags[$i] = $hashtag;
            }
        }

        return new self($hashtags);
    }

    /**
     * @param array $hashtags
     * @return HashtagsAttribute
     */
    public static function fromStringArray(array $hashtags): HashtagsAttribute
    {
        if (empty($hashtags)) {
            return new self($hashtags);
        }

        foreach ($hashtags as $i => $hashtag ) {
            $hashtag = trim($hashtag);
            if (empty($hashtag)) {
                unset($hashtags[$i]);
            } else {
                $hashtags[$i] = $hashtag;
            }
        }

        return new self($hashtags);
    }

    /**
     * @param string $text
     * @return HashtagsAttribute
     */
    public static function fromTextArray(string $text): HashtagsAttribute
    {
        preg_match_all('/#[^\s]+/', $text, $hashtagsDirty);
        if (!isset($hashtagsDirty[0])) {
            return new self([]);
        }
        if (!count($hashtagsDirty[0])) {
            return new self([]);
        }
        $hashtags = [];
        foreach($hashtagsDirty[0] as $ht) {
            $ht = ltrim($ht, '#');
            if (strlen($ht)) {
                $hashtags[] = $ht;
            }
        }

        return new self($hashtags);
    }
}
