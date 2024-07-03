<?php

namespace Tests\Unit;

use App\Models\Card;
use App\Jobs\StoreCard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreCardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }
    public function testStoreCard()
    {
        Storage::fake('public');
        $card = Card::factory()->create(['image_path' => 'http://localhost:8001/storage/cards/13cb9575-1138-4f99-8e90-0eaf00bdf4a1.jpg']);

        Http::fake([
            'http://localhost:8001/storage/cards/13cb9575-1138-4f99-8e90-0eaf00bdf4a1.jpg' => Http::response('dummy image content', 200),
        ]);

        StoreCard::dispatch($card);

        $this->assertTrue(Storage::exists('public/cards/13cb9575-1138-4f99-8e90-0eaf00bdf4a1.jpg'));
        $storedCard = Card::find($card->id);
        $this->assertEquals('/storage/cards/13cb9575-1138-4f99-8e90-0eaf00bdf4a1.jpg', $storedCard->image_path);
    }
}
