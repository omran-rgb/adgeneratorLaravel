<?php

use App\Http\Controllers\insertAnswars;
use App\Http\Controllers\readQuestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/questions', [readQuestions::class, 'get_all_question']);
Route::post('/answars', [insertAnswars::class, 'insert_answars']);
