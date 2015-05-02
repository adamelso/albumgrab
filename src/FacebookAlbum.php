<?php

namespace Albumgrab;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class FacebookAlbum implements Album
{
    /**
     * @var string
     */
    private $startingUrl;

    /**
     * @var Element
     */
    private $imageElement;

    /**
     * @var Element
     */
    private $nextButtonElement;

    /**
     * @param string  $startingUrl
     * @param Element $imageElement
     * @param Element $nextButtonElement
     */
    public function __construct($startingUrl, Element $imageElement, Element $nextButtonElement)
    {
        $this->startingUrl = $startingUrl;
        $this->imageElement = $imageElement;
        $this->nextButtonElement = $nextButtonElement;
    }

    /**
     * @return string
     */
    public function getStartingUrl()
    {
        return $this->startingUrl;
    }

    /**
     * @return Element
     */
    public function getImageElement()
    {
        return $this->imageElement;
    }

    /**
     * @return Element
     */
    public function getNextButtonElement()
    {
        return $this->nextButtonElement;
    }
}
