<?php

use App\Http\Controllers\AlQuranController;
use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/videos', [VideoController::class, 'allVideos'])->name('all-videos');
Route::get('/video/{slug}', [VideoController::class, 'videoDetail'])->name('video-detail');
Route::get('/video/{token}/more-related', [VideoController::class, 'moreRelatedVideos']);
Route::get('/video/{token}/more-comments', [VideoController::class, 'loadMoreComment']);

Route::prefix('/al-quran')->group(function () {
    Route::get('/edition', [AlquranController::class, 'index']);
});

