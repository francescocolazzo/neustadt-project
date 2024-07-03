<?php

namespace App\Http\Resources;

use App\Models\Card;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class CardResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return Collection
     */
    public function toArray($request)
    {
        /** @var Card $card */
        return $this->collection->map(function ($card) {
            return [
                'id'               => $card->getId(),
                'name'             => $card->getName(),
                'scryfall_card_id' => $card->getScryfallCardId(),
                'set_code'         => $card->getSetCode(),
                'path'             => $card->getImagePath(),
                'created_at'       => $card->getCreatedAt()
            ];
        });
    }
}
