<?php

declare(strict_types=1);

namespace App\Parsers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class GoodwillParser extends Parser {

    private function getToken(): ?string
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.goodwill.ge/connect/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "------WebKitFormBoundaryTJtI0coglFBybBhQ\r\nContent-Disposition: form-data; name=\"client_id\"\r\n\r\nGroceryWeb\r\n------WebKitFormBoundaryTJtI0coglFBybBhQ\r\nContent-Disposition: form-data; name=\"client_secret\"\r\n\r\nnukuy6ekop\r\n------WebKitFormBoundaryTJtI0coglFBybBhQ\r\nContent-Disposition: form-data; name=\"grant_type\"\r\n\r\nclient_credentials\r\n------WebKitFormBoundaryTJtI0coglFBybBhQ\r\nContent-Disposition: form-data; name=\"scope\"\r\n\r\nGroceryApi\r\n------WebKitFormBoundaryTJtI0coglFBybBhQ--\r\n");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'accept: application/json, text/plain, */*',
            'accept-language: en-GB,en-US;q=0.9,en;q=0.8,ka;q=0.7',
            'content-type: multipart/form-data; boundary=----WebKitFormBoundaryTJtI0coglFBybBhQ',
            'dnt: 1',
            'origin: https://www.goodwill.ge',
            'referer: https://www.goodwill.ge/',
            'sec-ch-ua: "Google Chrome";v="123", "Not:A-Brand";v="8", "Chromium";v="123"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Linux"',
            'sec-fetch-dest: empty',
            'sec-fetch-mode: cors',
            'sec-fetch-site: same-site',
            'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36'
        ));

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return json_decode($result)?->access_token;
    }

    public function fetchData(): void
    {
        $token = $this->getToken();

        if ($token != null){
            $data = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('https://api.goodwill.ge/v1/Products/v3?ShopId=1&Page=1&Limit=50000');

            $this->data = $data->json();
        }
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
        return (int)Arr::get($item, 'barCode', 0);
    }

    public function getPrice(array $item): int
    {
        return (int)Arr::get($item, 'price', 0);
    }

    public function getPriceBeforeSale(array $item): ?int
    {
        return (int)Arr::get($item, 'previousPrice',);
    }

    public function getCurrencyCode(array $item): string
    {
        return 'GEL';
    }

    public function getImageUrl(array $item): ?string
    {
        return Arr::get($item, 'imageUrl');
    }
}
