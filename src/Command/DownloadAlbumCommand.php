<?php

namespace ArchFizz\Facebook\AlbumDownloader\Command;

use Goutte\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class DownloadAlbumCommand extends Command
{
    const COMMAND_NAME = 'download';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Download all the images in a Facebook photo album.')
        ;
    }

    /**
     * @todo Refactor this procedure into reusable services.
     *
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getContainer();

        /** @var Client $client */
        $client = $container->get('client');

        /** @var Filesystem $fs */
        $fs = $container->get('filesystem');

        /** @var DialogHelper $dialog */
        $dialog = $this->getHelperSet()->get('dialog');

        $visitedUris = [];
        $imageUris = [];

        $imgSelector = '#fbPhotoImage';

        $album = $dialog->ask($output,
            "Please enter the name of the directory your images will be saved to: "
        );

        $uri = $dialog->ask($output,
            'Please enter the URL to the first image of the Facebook Photo Album you would like to download: '
        );

        $crawler = $client->request('GET', $uri);

        $output->writeln("Opening " . $uri);
        $visitedUris[] = $uri;

        $imgCrawler = $crawler->filter($imgSelector);
        $imgSrc = $imgCrawler->attr('src');

        $output->writeln("Image found $imgSrc");

        $imageUris[] = $imgSrc;

        $output->writeln(count($visitedUris));

        $link = $crawler->selectLink('Next')->link();

        $output->writeln($link->getUri());

        while (!in_array($link->getUri(), $visitedUris)) {
            $crawler = $client->click($link);

            $imgCrawler = $crawler->filter($imgSelector);
            $imgSrc = $imgCrawler->attr('src');

            $imageUris[] = $imgSrc;

            $output->writeln("Image found $imgSrc");

            $visitedUris[] = $link->getUri();

            $output->writeln(count($visitedUris));

            $link = $crawler->selectLink('Next')->link();
            $output->writeln("Opening " . $link->getUri());
        }

        $output->writeln(sprintf("Found %d images", count($imageUris)));

        $rootDir = $container->getParameter('root_dir');

        $imgDir = sprintf('%s/images/%s', $rootDir, $album);

        try {
            if (!$fs->exists($imgDir)) {
                $fs->mkdir($imgDir);
            }
        } catch (IOExceptionInterface $e) {
            $output->writeln("An error occurred while creating your directory at ".$e->getPath());

            exit(1);
        }

        foreach ($imageUris as $src) {
            $img = file_get_contents($src);

            $imgFilename = sprintf('%s/%s', $imgDir, basename($src));

            $output->writeln(sprintf("Saving image to %s", $imgFilename));

            $fs->dumpFile($imgFilename, $img);
        };
    }
}
