<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\FixturesController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/fixtures', [FixturesController::class, 'index'])->name('fixtures');

Route::prefix(cms('posts_slug') ?? 'posts')->group(function () {
    Route::get('/{slug}', [PostController::class, 'post'])->name('post');
    Route::get('/', [PostController::class, 'index'])->name('posts');
});

if( cms('events_enabled') ) {
    Route::prefix(cms('events_slug') ?? 'events')->group(function () {
        Route::get('/{slug}', [EventController::class, 'event'])->name('event');
        Route::get('/', [EventController::class, 'index'])->name('events');
    });
}

if( cms('projects_enabled') ) {
    Route::prefix(cms('projects_slug') ?? 'projects')->group(function () {
        Route::get('/{slug}', [ProjectController::class, 'project'])->name('project');
        Route::get('/', [ProjectController::class, 'index'])->name('projects');
    });
}

Route::get('/{slug}', [PageController::class, 'page'])->name('page');
Route::get('/', [PageController::class, 'home'])->name('home');

