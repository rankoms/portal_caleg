<?php

use Illuminate\Support\Facades\Route;


function areActiveRoutes(array $routes, $output = " open")
{
    $output = session('theme') == 'dark' ? 'active-dark open' : 'active-light open';
    foreach ($routes as $route) {
        if (Route::currentRouteName() == $route) return $output;
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
