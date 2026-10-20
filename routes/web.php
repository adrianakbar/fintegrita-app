<?php

use Illuminate\Support\Facades\Route;

// Company profile statis (repo fintegrita HTML) di root, panel tetap di /admin & /portal.
Route::get('/', fn () => response()->file(public_path('site/index.html')));
