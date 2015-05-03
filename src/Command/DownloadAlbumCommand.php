<?php

namespace Albumgrab\Command;

use Albumgrab\Downloader;
use Albumgrab\GrabFactory;
use Goutte\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\ContainerInterface;
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
        $client = $this->getClient();
        $filesystem = $this->getFilesystem();

        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $grabSaveDirName = $questionHelper->ask($input, $output, new Question(
            '<question>Please enter the name of the directory your images will be saved to. This will be saved in the "images" directory.</question> ',
            'grab'.time()
        ));

        $uri = $questionHelper->ask($input, $output, new Question(
            '<question>Please enter the URL to the first image of the Facebook Photo Album you would like to download.</question> '
        ));

        $linkText = $input->getOption('next');

        $saveDir = $this->getSaveDirectory($grabSaveDirName);

        $facebookGrab = GrabFactory::createFacebookGrab($uri, $saveDir, $linkText);

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

        /** @var Downloader $downloader */
        $downloader = $this->getContainer()->get('albumgrab.downloader');

        $downloader->download($facebookGrab);
    }

    /**
     * @return ContainerInterface
     */
    private function getContainer()
    {
        return $this->getApplication()->getContainer();
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        return $this->getContainer()->get('client');
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return $this->getContainer()->get('filesystem');
    }

    /**
     * @param string $grabSaveDir
     *
     * @return string
     */
    protected function getSaveDirectory($grabSaveDir)
    {
        return sprintf('%s/../images/%s', $this->getContainer()->getParameter('root_dir'), $grabSaveDir);
    }
}
