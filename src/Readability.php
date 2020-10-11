<?php namespace Readability;

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
        $process->run();

        if ($process->getExitCode() !== 0) {
            throw new ReadabilityException($process->getErrorOutput(), $process->getExitCode());
        }

        return trim($process->getOutput());
    }
}
