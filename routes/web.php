<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\shopItemController;
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
// show all items
Route::get('/list',[shopItemController::class, 'getallitems']);

// show all items of a sepcific store
Route::get('/items/{shopid}', [shopItemController::class, 'getitemsoneshop'])->where('shopid', '[0-9]+');

//show all shops
Route::get('/shops', [shopItemController::class, 'showShops']);

//page with form to add shops/items?
Route::get('/additems', [shopItemController::class, 'additemsandshops']);

//homepage
Route::get('/', function () {
    return view('actualwelcome', ['current' => url()->current()]);
});