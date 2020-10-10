<?php namespace Readability;

class ReadabilityArticle {
    private array $output;

    public function __construct(array $data) {
        $this->output = $data;
    }

    public function title():? string {
        return $this->output['title'] ?? null;
    }

    public function description():? int {
        return $this->output['excerpt'] ?? null;
    }

    public function author():? string {
        return $this->output['byline'] ?? null;
    }

    public function dir():? string {
        return $this->output['dir'] ?? null;
    }

    public function content():? string {
        return $this->output['content'] ?? null;
    }

    public function text():? string {
        return $this->output['textContent'] ?? null;
    }

    public function length():? int {
        return $this->output['length'] ?? null;
    }
}
