<?php

use App\Http\Controllers\AlQuranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/videos', [VideoController::class, 'allVideos'])->name('all-videos');
Route::get('/video/{slug}', [VideoController::class, 'videoDetail'])->name('video-detail');
Route::get('/video/{token}/more-related', [VideoController::class, 'moreRelatedVideos']);
Route::get('/video/{token}/more-comments', [VideoController::class, 'loadMoreComment']);

Route::middleware('auth:sanctum')->group(function (){
    Route::post('/video/{slug}/comment', [VideoController::class, 'comment']);
    Route::post('/video/{slug}/like', [VideoController::class, 'like']);
    Route::post('/video/{slug}/dislike', [VideoController::class, 'dislike']);
});




Route::prefix('user')->group(function (){
   Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('/al-quran')->group(function () {
    Route::get('/edition', [AlquranController::class, 'index']);
    Route::get('/surah', [AlquranController::class, 'getAllSurah']);
    Route::get('/surah/{surah_number}/ayahs', [AlquranController::class, 'getSurahAyahs']);
});

Route::prefix('/youtube')->group(function () {
    Route::get('/run', [\App\Http\Controllers\YoutubeApiController::class, 'run']);
    Route::get('/run-playlist', [\App\Http\Controllers\YoutubeApiController::class, 'runPlayList']);
    Route::get('/get-playlist/{channel_id}', [\App\Http\Controllers\YoutubeApiController::class, 'getPlayList']);
    Route::get('/get-playlist-items/{playlist_id}/{next_page_token?}', [\App\Http\Controllers\YoutubeApiController::class, 'getPlayListItems']);
    Route::get('/get-channel/{channel_id}', [\App\Http\Controllers\YoutubeApiController::class, 'getChannelId']);
});

