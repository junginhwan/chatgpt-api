<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PapagoService 
{
    private $client_id;
    private $client_secret;
    private $api_url;

    public function __construct()
    {
        $this->client_id = env('NAVER_CLIENT_ID');
        $this->client_secret = env('NAVER_CLIENT_SECRET');
        $this->api_url = env('NAVER_API_URL')."/v1/papago/n2mt";
    }

    public function translation(string $message, string $source = 'ko', string $target = 'en'): string
    {
        $result = "";
        $response = Http::withHeaders([
            'X-Naver-Client-Id' => $this->client_id,
            'X-Naver-Client-Secret' => $this->client_secret,
        ])->post($this->api_url, [
            'source' => $source,
            'target' => $target,
            'text' => $message,
        ]);
        if ($response->ok()) {
            $json = $response->json();
            $result = $json['message']['result']['translatedText'];
        }
        return $result;
    }
}