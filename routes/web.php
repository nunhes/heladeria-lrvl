<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CartController;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Session;

Route::get('/', [ProjectController::class, 'index'])->name('home');
Route::get('/products', [ProjectController::class, 'products'])->name('products');

/**
* requests a product ID that does not exist
* en caso de non atopar o produto redirixir a home
*/
Route::get('/single_product', function () {
    //return redirect()->route('home');
    return redirect('/');
});

Route::get('/single_product/{id}', [ProjectController::class, 'single_product'])->name('single_product');

Route::get('/cart', [CartController::class, 'cart'])->name('cart');

Route::get('/service', [CartController::class, 'cart'])->name('cart');

Route::post('/add_to_cart', [CartController::class, 'add_to_cart'])->name('add_to_cart');

/** retain this URL in case the user requests an empty cart */
Route::get('/add_to_cart', function () {
    //return redirect()->route('home');
    return redirect('/');
});


/** acceso a vistas estáticas */
Route::get('/about', function () {
    return view('about');
});

Route::get('/gallery',[ProjectController::class, 'gallery'])->name('gallery');

Route::get('/contact', function () {
    return view('contact');
});
Route::get('/terms', function () {
    return view('terms');
});  

/**
Route::get('/products', function () {
    return view('products');
});

Route::get('/about', function () {
    return view('about');
});*/