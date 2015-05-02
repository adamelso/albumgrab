<?php

namespace Albumgrab;

use Albumgrab\Event\DownloadAndSaveEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class Downloader
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var RemoteResourceClient
     */
    private $remoteResourceClient;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param Filesystem               $filesystem
     * @param RemoteResourceClient     $remoteResourceClient
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(Filesystem $filesystem, RemoteResourceClient $remoteResourceClient, EventDispatcherInterface $eventDispatcher)
    {
        $this->filesystem = $filesystem;
        $this->remoteResourceClient = $remoteResourceClient;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Grab $grab
     */
    public function download(Grab $grab)
    {
        foreach ($grab->getImageUrls() as $imageUrl) {
            $imgFilename = sprintf('%s/%s', $grab->getSavePath(), basename($imageUrl));
            $imageContent = $this->remoteResourceClient->getResource($imageUrl);

            $this->filesystem->dumpFile($imgFilename, $imageContent);

            $this->eventDispatcher->dispatch(DownloadAndSaveEvent::NAME, new DownloadAndSaveEvent($imgFilename));
        }
    }
}
