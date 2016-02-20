<?php

namespace Albumgrab\Console\Command;

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
class DownloadCommand extends Command
{
    const COMMAND_NAME = 'download';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Download all the images in a Facebook photo album.');
        $this->addOption('next', 'x', InputOption::VALUE_OPTIONAL, 'Specify the text used for the next button.', 'Next');
    }

    /**
     * @todo Refactor this procedure into reusable services.
     *
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getClient();
        $client->setHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/36.0');

        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $grabSaveDirName = $questionHelper->ask($input, $output, new Question(
            '<question>Please enter the name of the directory your images will be saved to. This can be an absolute path (eg: "/tmp/fbphotos"). Otherwise, relative paths will be relative to the "images" directory.</question>'.PHP_EOL,
            'grab'.time()
        ));

        $uri = $questionHelper->ask($input, $output, new Question(
            '<question>Please enter the URL to the first image of the Facebook Photo Album you would like to download.</question>'.PHP_EOL
        ));

        $linkText = $input->getOption('next');

        $saveDir = $this->getSaveDirectory($grabSaveDirName);

        $facebookGrab = GrabFactory::createFacebookGrab($uri, $saveDir, $linkText);

        $crawler = $client->request('GET', $uri);

        $output->writeln("Opening " . $uri);

        $facebookGrab->addVisitedUrl($uri);

        $imgCrawler = $crawler->filter($facebookGrab->getAlbum()->getImageElement()->getSelector());
        $imgSrc = $imgCrawler->attr('src');

        $output->writeln(sprintf("Image found %s", basename(parse_url($imgSrc)['path'])));

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

    bin/albumgrab --next="Siguiente"

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

            $output->writeln(sprintf("Image found %s", basename(parse_url($imgSrc)['path'])));

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
        if (0 === strpos($grabSaveDir, '/')) {
            return $grabSaveDir;
        }

        return sprintf('%s/../images/%s', $this->getContainer()->getParameter('root_dir'), $grabSaveDir);
    }
}
