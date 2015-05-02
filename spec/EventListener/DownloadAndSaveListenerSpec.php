<?php

namespace spec\Albumgrab\EventListener;

use Albumgrab\Event\DownloadAndSaveEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadAndSaveListenerSpec extends ObjectBehavior
{
    function let(OutputInterface $output)
    {
        $this->beConstructedWith($output);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Albumgrab\EventListener\DownloadAndSaveListener');
    }

    function it_logs_messages_to_the_console_when_a_download_is_saved(OutputInterface $output, DownloadAndSaveEvent $event)
    {
        $event->getFilePath()->willReturn('/tmp/420.jpg');

        $output->writeln('File saved to "/tmp/420.jpg"')->shouldBeCalled();

        $this->onDownloadAndSave($event);
    }
}
