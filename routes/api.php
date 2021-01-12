<?php

use App\Http\Controllers\API\PostController;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts', PostController::class);
