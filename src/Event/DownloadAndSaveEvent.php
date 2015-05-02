<?php

namespace Albumgrab\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class DownloadAndSaveEvent extends Event
{
    const NAME = 'albumgrab.download_and_save';

    /**
     * @var string
     */
    private $filePath;

    /**
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

}
