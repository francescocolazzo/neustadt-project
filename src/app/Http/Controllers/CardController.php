<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ScryfallService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardResourceCollection;
use App\Repositories\CardRepository;
use App\Requests\CardsRequest;
use App\Services\CardService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CardController extends Controller
{
    public function __construct(
        protected ScryfallService $scryfallService,
        protected CardService $cardService,
        protected CardRepository $cardRepo
    ) {
    }

    public function getCard(string $id): JsonResponse
    {
        $card = $this->scryfallService->getCardById($id);

        return response()->json([
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => [
                'card' => $card
            ],
        ],  Response::HTTP_OK);
    }

    public function deleteCard(int $cardId): JsonResponse
    {
        try {
            $this->cardService->deleteCard($cardId);
        } catch (Exception $e) {
            app('log')->error($e->getMessage(), $e->getTrace());
            throw new Exception($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $cards                  = $this->cardRepo->getCards(50, 1);
        $cards                  = $this->cardRepo->getCards();
        $cardResourceCollection = CardResourceCollection::make($cards);

        return response()->json([
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data'   => [
                'cards'      => $cardResourceCollection,
                'pagination' => [
                    'total'       => $cardResourceCollection->total(),
                    'perPage'     => $cardResourceCollection->perPage(),
                    'currentPage' => $cardResourceCollection->currentPage(),
                    'lastPage'    => $cardResourceCollection->lastPage(),
                ]
            ],
        ], Response::HTTP_OK);
    }

    public function getCards(Request $request): JsonResponse
    {
        $perPage = $request->input('perPage', 200);
        $page    = $request->input('page', 1);
        $name    = $request->input('name');
        $cards   = $this->cardRepo->getCards(perPage: $perPage, page: $page, name: $name);

        $cardResourceCollection = CardResourceCollection::make($cards);

        return response()->json([
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data'   => [
                'cards'      => $cardResourceCollection,
                'pagination' => [
                    'total'       => $cardResourceCollection->total(),
                    'perPage'     => $cardResourceCollection->perPage(),
                    'currentPage' => $cardResourceCollection->currentPage(),
                    'lastPage'    => $cardResourceCollection->lastPage(),
                ]
            ],
        ], Response::HTTP_OK);
    }

    public function getSets()
    {
        $sets = $this->scryfallService->getSets();

        return response()->json([
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data' => [
                'sets' => $sets
            ],
        ],  Response::HTTP_OK);
    }

    public function addCards(CardsRequest $request): JsonResponse
    {
        try {
            $cardsData = $this->scryfallService->getCardsBySetCode($request->getSetCode());
            $cards     = $this->cardService->addCards(Arr::get($cardsData, 'data'));
        } catch (Exception $e) {
            app('log')->error($e->getMessage(), $e->getTrace());
            throw new CustomException(
                $e->getMessage(),[]
            );
        }

        $cardResourceCollection = CardResourceCollection::make($cards);
        return response()->json([
            'status' => Response::$statusTexts[Response::HTTP_OK],
            'data'   => [
                'cards'      => $cardResourceCollection,
                'pagination' => [
                    'total'       => $cardResourceCollection->total(),
                    'perPage'     => $cardResourceCollection->perPage(),
                    'currentPage' => $cardResourceCollection->currentPage(),
                    'lastPage'    => $cardResourceCollection->lastPage(),
                ]
            ],
        ], Response::HTTP_OK);
    }
}
