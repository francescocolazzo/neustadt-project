<?php

namespace Tests\Feature;

use App\Models\Card;
use App\Services\ScryfallService;
use App\Services\CardService;
use App\Repositories\CardRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;

class CardControllerTest extends TestCase
{
    use RefreshDatabase;

    private $scryfallServiceMock;
    private $cardServiceMock;
    private $cardRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scryfallServiceMock = Mockery::mock(ScryfallService::class);
        $this->cardServiceMock = Mockery::mock(CardService::class);
        $this->cardRepositoryMock = Mockery::mock(CardRepository::class);

        $this->app->instance(ScryfallService::class, $this->scryfallServiceMock);
        $this->app->instance(CardService::class, $this->cardServiceMock);
        $this->app->instance(CardRepository::class, $this->cardRepositoryMock);
    }

    public function testGetCard()
    {
        $this->withExceptionHandling();
        $cardId = 111;
        $cardData = [
            'id' => $cardId,
            'scryfall_card_id' => 'iqijss223ji2i222k2w',
            'name' => 'Test Card',
            'set' => 'Test Set',
            'image_path' => ['small' => 'path/to/image.jpg']
        ];

        $this->scryfallServiceMock
            ->shouldReceive('getCardById')
            ->with($cardId)
            ->andReturn($cardData);

        $response = $this->getJson("/api/cards/$cardId");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => Response::$statusTexts[Response::HTTP_OK],
                'data' => [
                    'card' => $cardData
                ]
            ]);
    }

    public function testDeleteCard()
    {
        $this->withExceptionHandling();
        $cardId = 1;
        $card = Card::factory()->create(['id' => $cardId]);

        $this->cardServiceMock
            ->shouldReceive('deleteCard')
            ->with($cardId)
            ->andReturnNull();

        $this->cardRepositoryMock
            ->shouldReceive('getCards')
            ->andReturn($card->paginate());

        $response = $this->deleteJson("/api/card/$cardId");
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'cards',
                    'pagination'
                ]
            ]);
    }

    public function testGetCards()
    {
        $this->withExceptionHandling();
        Card::factory()->count(3)->create();

        $this->cardRepositoryMock
            ->shouldReceive('getCards')
            ->andReturn(Card::paginate());

        $response = $this->getJson("/api/cards");
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'cards',
                    'pagination'
                ]
            ]);
    }

    public function testGetSets()
    {
        $sets = [
            ['code' => 'war'],
            ['code' => 'war2']
        ];

        $this->scryfallServiceMock
            ->shouldReceive('getSets')
            ->andReturn($sets);

        $response = $this->getJson("/api/sets");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => Response::$statusTexts[Response::HTTP_OK],
                'data' => [
                    'sets' => $sets
                ]
            ]);
    }

    public function testAddCards()
    {
        $setCode = 'war';
        $cardsData = [
            'data' => [
                [
                    'id'               => 11,
                    'scryfall_card_id' => 'iqijss223ji2i222k2w',
                    'name'             => 'Test Card',
                    'set'              => 'Test Set',
                    'image_path'       => ['small' => 'path/to/image.jpg']
                ],
                [
                    'id'               => 43,
                    'scryfall_card_id' => 'iqijss223ji2i222k2w',
                    'name'             => 'Test Card',
                    'set'              => 'Test Set',
                    'image_path' => ['small' => 'path/to/image.jpg']
                ]
            ]
        ];

        $this->scryfallServiceMock
            ->shouldReceive('getCardsBySetCode')
            ->with($setCode)
            ->andReturn($cardsData);

        $this->cardServiceMock
            ->shouldReceive('addCards')
            ->with(($cardsData['data']))
            ->andReturn(Card::paginate());

        $response = $this->postJson("/api/cards", ['code' => $setCode]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'cards',
                    'pagination'
                ]
            ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
