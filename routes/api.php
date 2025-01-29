<?php

use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/videos', [VideoController::class, 'allVideos'])->name('all-videos');
