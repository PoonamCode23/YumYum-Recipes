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

Route::get('/', [RecipeController::class, 'homepage'])->name('homepage');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//this create and save route are kept above category route because category route takes create and save as its {category}parameter  and display blank page cuz such category doesnt exist
Route::get('/recipes/createrecipes', [RecipeController::class, 'create'])->name('recipes.createrecipes')->middleware('guard'); // guard ensures that user should be logged in first in order to perform the route


Route::get('/recipes/saved', [RecipeController::class, 'savedRecipe'])
    ->name('recipes.saved');

/*import controller*/
Route::get('/recipes/{category}', [RecipeController::class, 'showByCategory'])->name('recipes.category');


Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{recipe}/details', [RecipeController::class, 'details'])->name('recipes.details'); // this name should be added for naming routes in blade file. {recipe is the parameter passed in the controller  public function details($id)} think of it as a function to add two number and how parameter is passed in php.


Route::post('/recipes/store', [RecipeController::class, 'store'])->name('recipes.store')->middleware('guard');
// Route::get('/recipes/show/{recipe}', [RecipeController::class, 'show'])->name('recipes.show')->middleware('guard'); 
Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit')->middleware('guard'); //we are using get method to pass value in the url.
Route::PUT('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update')->middleware('guard');

Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy')->middleware('guard');
Route::get('/recipes/users/{user_id}', [RecipeController::class, 'userRecipes'])->name('recipes.user'); // user_id is passed to the parameter of userRecipes function. The name of the parameter can be any. it doesnt have to be $user_id. It can be $aaa as well or any other variables.


Route::post('/recipes/store-ratings', [RecipeController::class, 'storeReviews'])->name('recipes.store-ratings')->middleware('guard'); // use this way of routing. see details blade.php f orm
Route::put('/reviews/{comment}/updateReviews', [RecipeController::class, 'updateReviews'])->name('reviews.updateReviews'); // write comment here for route binding


// Route::post('/search-by-tag', [RecipeController::class, 'searchByTag'])->name('searchByTag');

Route::get('/recipes/saved', [RecipeController::class, 'savedRecipe'])
    ->name('recipes.saved');

Route::post('/comments/{commentId}/like', [RecipeController::class, 'likeComment'])
    ->middleware(['guard'])
    ->name('comments.like');

Route::post('/favourites/save', [RecipeController::class, 'saveRecipe'])
    ->middleware(['guard'])
    ->name('favourites.save');

require __DIR__ . '/auth.php';
