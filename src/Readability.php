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
        $this->html = str_replace('`', "'", $html);
        $this->url  = $url;
    }

    /**
     * @return ReadabilityArticle
     * @throws ReadabilityException
     */
    public function parse(): ReadabilityArticle {
        $output = json_decode($this->exec([$this->executable(), '-e', $this->jsCode()]), true);

        return new ReadabilityArticle($output);
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

    /**
     * @return string
     */
    private function jsCode(): string {
        return <<<JS
            var { Readability } = require('@mozilla/readability');
            var JSDOM = require('jsdom').JSDOM;
            var doc = new JSDOM(`{$this->html}`, {url: "{$this->url}"});
            let reader = new Readability(doc.window.document);
            let article = reader.parse();
            
            console.log(JSON.stringify(article));
        JS;
    }
}
