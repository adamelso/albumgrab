<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * @author Adam Elsodaney <adam.elso@gmail.com>
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $processCommand;
    private $phpCli;
    private $workingDir;
    private $commandName;
    private $filesystem;

    public function __construct()
    {
        $phpCliFinder = new PhpExecutableFinder();
        if (false === $phpCli = $phpCliFinder->find()) {
            throw new \RuntimeException('Unable to find the PHP executable.');
        }
        $this->phpCli = $phpCli;

        $this->processCommand = '';

        $this->filesystem = new Filesystem();
    }

    /**
     * @param string $command A valid Albumgrab command
     *
     * @return string
     */
    private function getCmd($command)
    {
        return escapeshellcmd(sprintf('%s bin/albumgrab %s --no-ansi', $this->phpCli, $command));
    }

    /**
     * @Given I am in the Albumgrab app directory
     */
    public function iAmInTheAlbumgrabAppDirectory()
    {
        $this->workingDir = __DIR__.'/../..';
    }

    /**
     * @When I run the Albumgrab :command command
     */
    public function iRun($command)
    {
        $this->commandName = $command;

        $expect = <<<BASH
exec expect -c '
set timeout 180
spawn {$this->getCmd($this->commandName)}

BASH;

        $this->processCommand .= $expect;
    }

    /**
     * @When when asked which directory to save to I answer :dir
     */
    public function iAnswerWhenAskedWhichDirectoryToSaveTo($dir)
    {
        $expect = <<<BASH
expect "Please enter the name of the directory"
send "{$dir}\n"

BASH;

        $this->processCommand .= $expect;
    }

    /**
     * @When when asked the URL to an image in a photo album I answer:
     */
    public function whenAskedTheUrlToAnImageInAPhotoAlbumIAnswer(PyStringNode $url)
    {
        $url = (string) $url;

        $expect = <<<BASH
expect "Please enter the URL to the first image"
send "{$url}\\n"

BASH;

        $this->processCommand .= $expect;

    }

    /**
     * @Then it should print:
     */
    public function itShouldPrint(PyStringNode $expectedOutput)
    {
        $interact = <<<BASH
expect EOF
'

BASH;

        $this->processCommand .= $interact;

        $process = new Process($this->processCommand);

        $process->setWorkingDirectory($this->workingDir);
        $process->setTimeout(3600);
        $process->setIdleTimeout(60);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $actualOutput = $this->normalizeNewlines($process->getOutput());
        $expectedOutput = $this->prependExpectScriptUsage($expectedOutput);

        $this->filesystem->dumpFile('/tmp/actual_output.txt', $actualOutput);
        $this->filesystem->dumpFile('/tmp/expected_output.txt', $expectedOutput);

        $diffProcess = new Process('diff /tmp/expected_output.txt /tmp/actual_output.txt');
        $diffProcess->run();

        echo '==== OUTPUT DIFF ====';
        echo $diffProcess->getOutput();

        expect($actualOutput)->toBe($expectedOutput);
    }

    /**
     * @param string $output
     *
     * @return string
     */
    private function normalizeNewlines($output)
    {
        return preg_replace('/[\x0A\x0D]+/', PHP_EOL, $output);
    }

    /**
     * @param PyStringNode $expectedOutput
     *
     * @return string
     */
    private function prependExpectScriptUsage(PyStringNode $expectedOutput)
    {
        return 'spawn '.$this->getCmd($this->commandName).PHP_EOL.$expectedOutput;
    }

    /**
     * @Given /^when asked the URL to the Instagram profile I answer "([^"]*)"$/
     */
    public function whenAskedTheURLToTheInstagramProfileIAnswer($arg1)
    {
        throw new PendingException();
    }
}
