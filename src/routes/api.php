<?php

use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/cards'], function () {
    Route::get('/',            [CardController::class, 'getCards'] );     # GET    api/cards
    Route::post('/',           [CardController::class, 'addCards'] );     # POST   api/cards
    Route::get('/{id}',        [CardController::class, 'getCard'] );      # GET    api/cards/{id}
});
Route::delete('/card/{cardId}', [CardController::class, 'deleteCard'] );  # DELETE api/card/{cardId}
Route::get('/sets',          [CardController::class, 'getSets'] );     # GET   api/sets

