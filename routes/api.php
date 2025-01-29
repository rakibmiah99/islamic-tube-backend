<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return \App\Utils\Helper::ApiResponse('Hello World');
});
