<?php

namespace spec\Albumgrab;

use Albumgrab\Event\DownloadAndSaveEvent;
use Albumgrab\Grab;
use Albumgrab\RemoteResourceClient;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Filesystem;

class DownloaderSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem, RemoteResourceClient $remoteResourceClient, EventDispatcherInterface $eventDispatcher)
    {
        $this->beConstructedWith($filesystem, $remoteResourceClient, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Albumgrab\Downloader');
    }

    function it_downloads_an_album(Grab $grab, Filesystem $filesystem, RemoteResourceClient $remoteResourceClient, EventDispatcherInterface $eventDispatcher)
    {
        $grab->getImageUrls()->willReturn([
            'http://fb.me/photo/1.jpg',
            'http://fb.me/photo/2.jpg',
        ]);

        $grab->getSavePath()->willReturn('/tmp');

        $filesystem->exists('/tmp')->willReturn(false);
        $filesystem->mkdir('/tmp')->shouldBeCalled();

        $remoteResourceClient->getResource('http://fb.me/photo/1.jpg')->willReturn('IMAGEBLOB_1');
        $remoteResourceClient->getResource('http://fb.me/photo/2.jpg')->willReturn('IMAGEBLOB_2');

        $filesystem->dumpFile('/tmp/1.jpg', 'IMAGEBLOB_1')->shouldBeCalled();
        $filesystem->dumpFile('/tmp/2.jpg', 'IMAGEBLOB_2')->shouldBeCalled();

        $eventDispatcher->dispatch('albumgrab.download_and_save', new DownloadAndSaveEvent('/tmp/1.jpg'))->shouldBeCalled();
        $eventDispatcher->dispatch('albumgrab.download_and_save', new DownloadAndSaveEvent('/tmp/2.jpg'))->shouldBeCalled();

        $this->download($grab);
    }
}
