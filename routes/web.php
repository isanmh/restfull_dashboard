<?php

use App\Http\Controllers\BasicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return "Hallo Dunia";
});

// arrow function = () => {}
Route::get('/user', fn () => "User");

// route menggunakan paramerter
Route::get('/user/{name}', function ($name) {
    return "Halo nama saya $name";
})->where('name', '[A-Za-z]+');


// route menggunakan paramerter
Route::get('/user/{name}', function ($name) {
    return "Halo nama saya $name";
    // })->where('name', '[A-Za-z]+');
    // })->where('name', '[0-9]+');
    // })->whereAlphaNumeric('name');
})->whereNumber('name');

// route menggunakan controller
Route::get('/', [BasicController::class, 'index']);
Route::get('/about', [BasicController::class, 'about'])->name('about');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// route untuk resource (CRUD)
// Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// refactor group routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
    Route::get('/products/trash', [ProductController::class, 'trash'])->name('products.trash');
    Route::get('/products/restore/{id}', [ProductController::class, 'restore'])->name('products.restore');
    // /products/force-delete/1 (DELETE) name -> force-delete / diblade products.force-delete
    Route::delete('/products/force-delete/{id}', [ProductController::class, 'deletePermanent'])->name('products.force-delete');

    // CRUD resources
    Route::resource('products', ProductController::class);
});
