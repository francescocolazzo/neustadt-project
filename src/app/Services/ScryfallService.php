<?php

namespace App\Services;

use App\Exceptions\CustomException;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ScryfallService
{
    protected string $basePath;
    public function __construct()
    {
        $this->basePath = env('SCRYFALL_URL');
    }

    public function getCardsBySetCode(string $code): array
    {
        return $this->fetchFromScryfall("/cards/search?", [
            'order'  => 'set',
            'q'      => "e:{$code}",
            'unique' => 'prints'
        ])->json();
    }

    public function getCardById(string $scryfall_card_id): array
    {
        return $this->fetchFromScryfall("/cards/$scryfall_card_id")->json();
    }

    public function getSets(): array
    {
        return $this->fetchFromScryfall("/sets")->json();
    }

    private function fetchFromScryfall($url, $param = null): Response
    {
        $response = Http::get($this->basePath . $url, $param);
        if ($response->successful()) {
            return $response;
        }

        app('log')->error($response->getReasonPhrase());
        throw new CustomException(
            $response->getReasonPhrase(),
            [
                'url'   => $url,
                'param' => $param
            ]
        );
    }
}
