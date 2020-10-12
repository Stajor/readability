<?php namespace Readability;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class Readability
 * @package Readability
 */
class Readability {
    private string $html;
    private string $url;

    public function __construct(string $html, string $url) {
        $this->html = $html;
        $this->url  = $url;
    }

    /**
     * @return ReadabilityArticle
     * @throws ReadabilityException
     */
    public function parse(): ReadabilityArticle {
        $output = $this->exec([$this->executable(), __DIR__.'/readability.js', $this->url, $this->html]);

        return new ReadabilityArticle(json_decode($output, true));
    }

    /**
     * @return string
     * @throws ReadabilityException
     */
    private function executable(): string {
        return $this->exec(['which', 'node']);
    }

    /**
     * @param array $commands
     * @return string
     * @throws ReadabilityException
     */
    private function exec(array $commands) {
        $process = new Process($commands);

        try {
            $process->mustRun();
            $process->stop(3, SIGINT);
        } catch (ProcessFailedException $e) {
            throw new ReadabilityException($e->getMessage(), $e->getCode(), $e);
        }

        return trim($process->getOutput());
    }
}
