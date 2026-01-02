<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;


Route::get('/fetch-api', [PokemonController::class, 'fetch']);
Route::get('/Pokemon', [PokemonController::class, 'index']);
Route::get('/', function () {
    return view('welcome');
});
