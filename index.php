<?php

use App\Controllers\Auth\SessionController;
use App\Controllers\OrderController;
use App\Controllers\ProductController;
use App\Controllers\UserController;
use App\Http\Route;

require_once './vendor/autoload.php';

session_start();

Route::post('login', [SessionController::class, 'login']);
Route::post('logout', [SessionController::class, 'logout']);
Route::post('register', [UserController::class, 'store']);
Route::get('orders', [OrderController::class, 'index']);
Route::get('order/{id}', [OrderController::class, 'show']);
Route::post('orders', [OrderController::class, 'store']);
Route::post('products', [ProductController::class, 'store']);
Route::get('products', [ProductController::class, 'index']);
