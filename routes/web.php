<?php

use App\Http\Controllers;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::middleware('auth')->group(function (Router $router)
{
    $router->get('/', [Controllers\HomeController::class, 'index'])->name('home');
    $router->match(['get', 'post'],'accounting/delete/{id}', [Controllers\HomeController::class, 'delete'])->name('accounting.delete');
    $router->post('add', [Controllers\HomeController::class, 'store'])->name('accounting.add');

    Route::prefix('categories')->group(function (Router $router)
    {
        $router->get('index', [Controllers\CategoriesController::class, 'index'])->name('categories.index');
    });
});
