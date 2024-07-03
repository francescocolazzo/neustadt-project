<?php

namespace App\Services;

use App\Jobs\StoreCard;
use App\Models\Card;
use App\Repositories\CardRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class CardService
{
    public function __construct(
        protected CardRepository $cardRepo
    ) {
    }

    public function addCards(array $cards): LengthAwarePaginator
    {
        foreach ($cards as $cardData) {
            $retrieveCard = $this->cardRepo->getCardByScryfallCardId($cardData['id']);
            if (!!$retrieveCard) {
                continue;
            }
            $card = new Card();
            $card
                ->setName($cardData['name'])
                ->setScryfallCardId($cardData['id'])
                ->setSetCode($cardData['set'])
                ->setImagePath($cardData['image_uris']['small'])
                ->save();
               
            StoreCard::dispatch($card);
        }
        return $this->cardRepo->getCards();
    }

    public function deleteCard(int $cardId): void
    {
        $card = $this->cardRepo->getCard($cardId);
        if ($card) {
            $imagePath = str_replace('/storage', 'public', $card->getImagePath());
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
    
            $card->delete();
        }
    }
}


