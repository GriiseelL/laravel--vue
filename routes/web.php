<?php

use Illuminate\Support\Facades\Route;

Route::post('/', function () {
    return view('welcome');
});
// Route::get('/login', function () {
//     return view('welcome');
// });

Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');