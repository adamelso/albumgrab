<?php

namespace spec\Albumgrab\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DownloadAndSaveEventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('/tmp/69.jpg');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Albumgrab\Event\DownloadAndSaveEvent');
    }

    function it_is_a_Symfony_event()
    {
        $this->shouldHaveType('Symfony\Component\EventDispatcher\Event');
    }

    function it_exposes_the_downloaded_file_path()
    {
        $this->getFilePath()->shouldBe('/tmp/69.jpg');
    }
}
