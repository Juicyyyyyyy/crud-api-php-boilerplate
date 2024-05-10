<?php
use TinyRouter\Render\View;
use TinyRouter\Routes\Route;
use App\Controllers\OutingController;

$outing_controller = OutingController::class;

Route::get('/', function () {
    return View::render('welcome', [
        'title' => 'Accueil'
    ]);
});

Route::get('product', function () {
    return View::render('product', [
        'title' => 'ahaha'
    ]);
});

Route::get('users', function () {
    return View::render('users', [
        'title' => 'Users'
    ]);
});