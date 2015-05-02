<?php

namespace Albumgrab;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class Grab implements \Countable
{
    /**
     * @var Album
     */
    private $album;

    /**
     * @var string
     */
    private $savePath;

    /**
     * @var string[]
     */
    private $visitedUrls = [];

    /**
     * @var string[]
     */
    private $imageUrls = [];

    /**
     * @param Album $album
     */
    public function __construct(Album $album, $savePath)
    {
        $this->album = $album;
        $this->savePath = $savePath;
    }

    /**
     * @param string $url
     */
    public function addVisitedUrl($url)
    {
        $this->visitedUrls[] = $url;
    }

    /**
     * @param string $url
     *
     * @return boolean
     */
    public function hasVisitedUrl($url)
    {
        return in_array($url, $this->visitedUrls);
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->visitedUrls);
    }

    /**
     * @param string $url
     */
    public function addImageUrl($url)
    {
        $this->imageUrls[] = $url;
    }

    /**
     * @param string $url
     *
     * @return boolean
     */
    public function hasImageUrl($url)
    {
        return in_array($url, $this->imageUrls);
    }

    /**
     * @return Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @return string[]
     */
    public function getImageUrls()
    {
        return $this->imageUrls;
    }

    /**
     * @return string
     */
    public function getSavePath()
    {
        return $this->savePath;
    }
}
