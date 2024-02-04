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
            $this->data = Http::withoutVerifying()
                ->withHeaders([
                    'User-Agent' =>     'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                ])
                ->get($this->url.urlencode($keyword))->json();
        } catch (\Exception $e) {
            dump($e->getMessage());
            dd($this->url.urlencode($keyword));
        }

    }
}
