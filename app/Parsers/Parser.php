<?php

namespace App\Parsers;

use Illuminate\Support\Facades\Http;

abstract class Parser
{
    public abstract function getItems(): array;

    public abstract function getCode(array $item): int;

    public abstract function getPrice(array $item): int;

    public array $data = [];

    public function __construct(
        public string $url,
    ) {
    }

    public function fetchData(string $keyword): void
    {
        try {
            $this->data = Http::withoutVerifying()->get($this->url.urlencode($keyword))->json();
        } catch (\Exception $e) {
            dump($e->getMessage());
            dd($this->url.urlencode($keyword));
        }

    }
}
