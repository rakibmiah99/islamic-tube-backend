<?php

use App\Http\Controllers\AlQuranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\UserPlayListController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/videos', [VideoController::class, 'allVideos'])->name('all-videos');
Route::post('/search/{text}', [VideoController::class, 'search'])->name('search');
Route::get('/video/{slug}', [VideoController::class, 'videoDetail'])->name('video-detail');
Route::get('/video/{token}/more-related', [VideoController::class, 'moreRelatedVideos']);
Route::get('/video/{token}/more-comments', [VideoController::class, 'loadMoreComment']);

Route::middleware('auth:sanctum')->group(function (){
    Route::post('/video/{slug}/comment', [VideoController::class, 'comment']);
    Route::post('/video/{slug}/like', [VideoController::class, 'like']);
    Route::post('/video/{slug}/dislike', [VideoController::class, 'dislike']);

    Route::prefix('user')->group(function (){
        Route::get('/playlist', [UserPlayListController::class, 'get']);
        Route::post('/playlist/create', [UserPlayListController::class, 'create']);
        Route::post('/playlist/{id}/delete', [UserPlayListController::class, 'delete']);
        Route::post('/playlist/{id}/update', [UserPlayListController::class, 'update']);
        Route::post('/playlist/{id}/update', [UserPlayListController::class, 'update']);
        Route::post('/playlist/{id}/get-video', [UserPlayListController::class, 'getVideos']);

        Route::post('/playlist/add-video', [UserPlayListController::class, 'addVideoInPlayList']);
    });
});




Route::prefix('user')->group(function (){
   Route::post('/login', [AuthController::class, 'login']);
});


// for testing
Route::prefix('/al-quran')->group(function () {
    Route::get('/audio', [AlQuranController::class, 'audio']);
    Route::get('/bangla', [AlQuranController::class, 'bangla']);
    Route::get('/english', [AlQuranController::class, 'english']);
    Route::get('/edition', [AlquranController::class, 'index']);
    Route::get('/surah', [AlquranController::class, 'getAllSurah']);
    Route::get('/surah/{surah_number}/ayahs', [AlquranController::class, 'getSurahAyahs']);
});


Route::prefix('quran')->group(function () {
    Route::get('/surah', [QuranController::class, 'getSurahs']);
    Route::get('/surah/{id}/details', [QuranController::class, 'surahDetails']);
});


Route::prefix('/youtube')->group(function () {
    Route::get('/run', [\App\Http\Controllers\YoutubeApiController::class, 'run']);
    Route::get('/run-playlist', [\App\Http\Controllers\YoutubeApiController::class, 'runPlayList']);
    Route::get('/get-playlist/{channel_id}', [\App\Http\Controllers\YoutubeApiController::class, 'getPlayList']);
    Route::get('/get-playlist-items/{playlist_id}/{next_page_token?}', [\App\Http\Controllers\YoutubeApiController::class, 'getPlayListItems']);
    Route::get('/get-channel/{channel_id}', [\App\Http\Controllers\YoutubeApiController::class, 'getChannelId']);
});

