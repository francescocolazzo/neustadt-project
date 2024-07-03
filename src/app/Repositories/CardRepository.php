<?php

namespace App\Repositories;

use App\Models\Card;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CardRepository
{
    public function getCard(int $cardId): ?Card
    {
        return Card::find($cardId);
    }

    public function getCards(?int $perPage = 200, ?int $page = 1, string $name = null): LengthAwarePaginator
    {
        $query = Card::query();

        if ($name) {
            $query->where('name', 'like', "%$name%");
        }
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getCardByScryfallCardId($scryfall_card_id): ?Card
    {
        return Card::where('scryfall_card_id', $scryfall_card_id)->first();
    }
}
