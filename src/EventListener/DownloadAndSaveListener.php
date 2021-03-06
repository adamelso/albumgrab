<?php

namespace Albumgrab\EventListener;

use Albumgrab\Event\DownloadAndSaveEvent;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadAndSaveListener
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param DownloadAndSaveEvent $event
     */
    public function onDownloadAndSave(DownloadAndSaveEvent $event)
    {
        $this->output->writeln(sprintf('File saved to "%s"', $event->getFilePath()));
    }
}
