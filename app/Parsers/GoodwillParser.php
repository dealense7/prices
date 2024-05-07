<?php

declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class GoodwillParser extends Parser
{
    public static string $token;

    public function fetchData(): void
    {
        if (empty(static::$token)) {
            static::$token = $this->getToken();
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . static::$token,
        ])->withoutVerifying()->get($this->url);

        $this->data = $response->json();
    }

    public function getName(array $item): string
    {
        return $item['name'];
    }

    public function getItems(): array
    {
        $items = Arr::get($this->data, 'products', []);

        return $this->generateResult($items);
    }

    public function getCode(array $item): int
    {
        return (int) Arr::get($item, 'barCode', 0);
    }

    public function getPrice(array $item): int
    {
        return (int) (Arr::get($item, 'price', 0) * 100);
    }

    public function getPriceBeforeSale(array $item): ?int
    {
        return (int) Arr::get($item, 'previousPrice',);
    }

    public function getCurrencyCode(array $item): string
    {
        return 'GEL';
    }

    public function getImageUrl(array $item): ?string
    {
        return Arr::get($item, 'imageUrl');
    }

    public function getCategoryId(array $item): ?int
    {
        $mapper = config('custom.category-maper.goodwill');

        return Arr::get($mapper, Arr::get($item, 'subCategoryId'));
    }

    private function getToken(): ?string
    {
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://api.goodwill.ge/connect/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json, text/plain, */*',
            'accept-language: en-GB,en-US;q=0.9,en;q=0.8,ka;q=0.7',
            'content-type: application/x-www-form-urlencoded',
            'origin: https://www.goodwill.ge',
            'referer: https://www.goodwill.ge/',
            'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'client_id'     => 'GroceryWeb',
            'client_secret' => 'nukuy6ekop',
            'grant_type'    => 'client_credentials',
            'scope'         => 'GroceryApi',
        ]));

        // Disable SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        // GET response
        return json_decode($response)?->access_token;
    }
}
