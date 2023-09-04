<?php

use App\Controllers\Page;
use App\Controllers\Update;
use Lemon\Route;

Route::get('/update', [Update::class, 'handle']);
Route::get('/{page}', [Page::class, 'handle']);
Route::get('/', [Page::class, 'first']);
