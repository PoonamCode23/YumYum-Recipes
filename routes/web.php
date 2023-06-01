<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [RecipeController::class, 'welcome'])->name('welcome');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/*import controller*/


Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{recipe}/details', [RecipeController::class, 'details'])->name('recipes.details');
Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create')->middleware('guard');
Route::post('/recipes/store', [RecipeController::class, 'store'])->name('recipes.store')->middleware('guard');
Route::get('/recipes/show/{recipe}', [RecipeController::class, 'show'])->name('recipes.show')->middleware('guard'); // guard ensures that user should be logged in first in order to perform the route

Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit')->middleware('guard');
Route::PUT('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update')->middleware('guard');

Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy')->middleware('guard');


require __DIR__ . '/auth.php';
