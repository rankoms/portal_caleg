<?php

use Illuminate\Support\Facades\Route;

function are_active_routes(array $routes)
{
    foreach ($routes as $route) {
        if (Route::currentRouteName() == $route) return true;
    }
}

function penjelasan_singkat($x, $length)
{
    if (strlen($x) <= $length) {
        return $x;
    } else {
        $y = substr($x, 0, $length) . '...';
        return $y;
    }
}
