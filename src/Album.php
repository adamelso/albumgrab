<?php

namespace Albumgrab;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
interface Album
{
    /**
     * @return string
     */
    public function getStartingUrl();

    /**
     * @return Element
     */
    public function getImageElement();

    /**
     * @return Element
     */
    public function getNextButtonElement();
}
