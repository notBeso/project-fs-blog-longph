<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;

// show list
Route::get('/blogs', [BlogController::class, 'index']);

// create item
Route::post('/blogs/create', [BlogController::class, 'store']);

// search item
Route::get('/blogs/search', [BlogController::class, 'search']);

// locations
Route::get('/blogs/locations', [BlogController::class, 'locations']);

// options
Route::get('/blogs/options', [BlogController::class, 'options']);

// show item
Route::get('/blogs/{id}', [BlogController::class, 'show']);

// update new info to item
Route::put('/blogs/{id}', [BlogController::class, 'update']);

// delete item
Route::delete('/blogs/{id}/delete', [BlogController::class, 'destroy']);

