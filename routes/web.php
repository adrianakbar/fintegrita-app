<?php

use Illuminate
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->away('https://fintegrita.com');
});
