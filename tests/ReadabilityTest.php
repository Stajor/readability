<?php

use PHPUnit\Framework\TestCase;

class ReadabilityTest extends TestCase {
    public function testParse() {
        $html = file_get_contents(__DIR__.'/test.html');
        $url = 'https://www.example.com/the-page-i-got-the-source-from';
        $readability = new Readability\Readability($html, $url);
        $article = $readability->parse();

        $this->assertEquals('Readability', $article->title());
        $this->assertEquals('Alex', $article->author());
        $this->assertEquals('ltr', $article->dir());
        $this->assertNotEmpty($article->content());
        $this->assertNotEmpty($article->text());
        $this->assertGreaterThan(0, $article->length());
    }
}
