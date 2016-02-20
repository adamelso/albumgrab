<?php

namespace Albumgrab\Console\Command;

use Albumgrab\Console\AlbumgrabApplication;
use Blackfire\Player\Result;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Blackfire\Player\Player;
use Blackfire\Player\Scenario;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class DebugPageSourceCommand extends Command
{
    const COMMAND_NAME = 'debug:source';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Debug the page source.');
    }

    /**
     * @todo Refactor this procedure into reusable services.
     *
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $r = $this->runScenario();

        /** @var string[] $scripts */
        $scripts = $r['scripts'];

        $output->writeln(sprintf('<comment>Found <info>%d</info> scripts on the page.</comment>', count($scripts)));

        usort($scripts, function (string $a, string $b) {
            return strlen($b) <=> strlen($a);
        });

        $sharedData = array_shift($scripts);

        $v8 = new \V8Js();

        VarDumper::dump($v8->executeString('var window = {}; '. $sharedData));

        return 0;
    }

    /**
     * @return Result
     */
    private function runScenario()
    {
        $scenario = new Scenario('Scenario Name');
        $scenario
            ->endpoint('https://www.instagram.com')
            ->visit("url('/travelgram/')")
            ->expect('status_code() == 200')
            ->extract('scripts', 'css("script")')
        ;

        $client = new GuzzleClient([
            'cookies' => true,
        ]);

        $player = new Player($client);

        return $player->run($scenario);
    }

    /**
     * @param string $id
     *
     * @return object
     */
    private function getService($id)
    {
        /** @var AlbumgrabApplication $application */
        $application = $this->getApplication();

        return $application->getContainer()->get($id);
    }
}
