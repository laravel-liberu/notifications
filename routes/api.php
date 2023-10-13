<?php

use Illuminate\Support\Facades\Route;
use LaravelLiberu\Notifications\Http\Controllers\Count;
use LaravelLiberu\Notifications\Http\Controllers\Destroy;
use LaravelLiberu\Notifications\Http\Controllers\DestroyAll;
use LaravelLiberu\Notifications\Http\Controllers\Index;
use LaravelLiberu\Notifications\Http\Controllers\Read;
use LaravelLiberu\Notifications\Http\Controllers\ReadAll;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/core/notifications')
    ->as('core.notifications.')
    ->group(function () {
        Route::get('', Index::class)->name('index');
        Route::delete('destroyAll', DestroyAll::class)->name('destroyAll');
        Route::delete('{notification}', Destroy::class)->name('destroy');
        Route::get('count', Count::class)->name('count');
        Route::patch('read/{notification}', Read::class)->name('read');
        Route::post('readAll', ReadAll::class)->name('readAll');
    });
