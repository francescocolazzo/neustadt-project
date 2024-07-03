<?php

namespace App\Jobs;

use App\Models\Card;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class StoreCard implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected Card $card)
    {
        $this->card = $card;
    }

    /**
     * Card should be saved properly into a CDN service (AWS, GOOGLE STORAGE, and so forth)
     * I have just used local storage such as an example
     */
    public function handle()
    {
        $response  = Http::get($this->card->getImagePath());
        $imageName = 'public/cards/' . basename(parse_url($this->card->getImagePath(), PHP_URL_PATH));

        Storage::put($imageName, $response->body());
        $this->card->setImagePath(Storage::url($imageName));
       
        $this->card->save();
    }
}
