<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('create/category', function () {
    $create = Category::create([
        'title' => 'London to Paris',
        'slug' => 'sludg' ]);
    if (!$create = true) {
     return "recorde not ok";
    }
    return "create successfully";




});
