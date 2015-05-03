<?php

namespace Albumgrab\Command;

use Albumgrab\Downloader;
use Albumgrab\Element;
use Albumgrab\FacebookAlbum;
use Albumgrab\Grab;
use Albumgrab\GrabFactory;
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
            ->addOption('next', 'x', InputOption::VALUE_OPTIONAL, 'Specify the text used for the next button.', 'Next')
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

        $grabSaveDir = $dialog->ask($output, "<question>Please enter the name of the directory your images will be saved to: This will be saved in the 'images' directory.</question>");

        $uri = $dialog->ask($output,
            '<question>Please enter the URL to the first image of the Facebook Photo Album you would like to download: </question>'
        );

        $linkText = $input->getOption('next');

        $rootDir = $container->getParameter('root_dir');
        $imgDir = sprintf('%s/../images/%s', $rootDir, $grabSaveDir);

        $facebookGrab = GrabFactory::createFacebookGrab($uri, $imgDir, $linkText);

        $crawler = $client->request('GET', $uri);

        $output->writeln("Opening " . $uri);

        $facebookGrab->addVisitedUrl($uri);

        $imgCrawler = $crawler->filter($facebookGrab->getAlbum()->getImageElement()->getSelector());
        $imgSrc = $imgCrawler->attr('src');

        $output->writeln("Image found $imgSrc");

        $facebookGrab->addImageUrl($imgSrc);

        $output->writeln(count($facebookGrab));

        $linkCrawler = $crawler->selectLink($facebookGrab->getAlbum()->getNextButtonElement()->getSelector());

        if ($linkCrawler->count() === 0) {
            $errorMessage = <<<EOL
The link with text "%s" could not found on the page.
EOL;

            if ('Next' === $linkText) {
                $errorMessage .= <<<EOL

If your Facebook page is not in English, please run the command again
using the equivalent word for 'Next in your language.

For example, en Español:

    ./albumgrab --next="Siguiente"

EOL;
            }

            throw new \RuntimeException(sprintf($errorMessage,  $linkText));
        }

        $link = $linkCrawler->link();

        $output->writeln($link->getUri());

        // @todo Write Behat scenarios for this, rather than testing manually.
        // while (count($facebookGrab) < 5) {

        while (! $facebookGrab->hasVisitedUrl($link->getUri())) {
            $crawler = $client->click($link);

            $imgCrawler = $crawler->filter($facebookGrab->getAlbum()->getImageElement()->getSelector());
            $imgSrc = $imgCrawler->attr('src');

            $facebookGrab->addImageUrl($imgSrc);

            $output->writeln("Image found $imgSrc");

            $facebookGrab->addVisitedUrl($link->getUri());

            $output->writeln(count($facebookGrab));

            $link = $crawler->selectLink('Next')->link();
            $output->writeln("Opening " . $link->getUri());
        }

        $output->writeln(sprintf("Found %d images", count($facebookGrab)));


        try {
            if (!$fs->exists($imgDir)) {
                $fs->mkdir($imgDir);
            }
        } catch (IOExceptionInterface $e) {
            $output->writeln("An error occurred while creating your directory at ".$e->getPath());

            exit(1);
        }

        /** @var Downloader $downloader */
        $downloader = $container->get('albumgrab.downloader');

        $downloader->download($facebookGrab);
    }
}
