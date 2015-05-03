<?php

namespace Albumgrab;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class GrabFactory
{
    const FACEBOOK_IMAGE_CSS_SELECTOR = '#fbPhotoImage';

    /**
     * @param string $uri
     * @param string $imgDir
     * @param string $linkText
     *
     * @return Grab
     */
    public static function createFacebookGrab($uri, $imgDir, $linkText = 'Next')
    {
        return new Grab(new FacebookAlbum(
            $uri,
            new Element(Element::CSS_TYPE, self::FACEBOOK_IMAGE_CSS_SELECTOR),
            new Element(Element::TEXT_TYPE, $linkText)
        ), $imgDir);
    }
}
