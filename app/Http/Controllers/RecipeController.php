<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRecipe;
use App\Http\Requests\StoreReviews;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Favourite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RecipeController extends Controller
{
    // (Request $request) retrieve information about the incoming HTTP request, such as form data or query parameters
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        if (!empty($keyword)) {
            $recipes = Recipe::where('title', 'LIKE', "%$keyword%")->inRandomOrder()->paginate(10);
            $message = count($recipes) > 0 ? "Search List for '$keyword'" : "No results found for '$keyword'. Please try searching other recipes.";
        } else {
            //the user_id column is typically expected to match the id of the currently authenticated user.' user_id' refers to the column name in the recipes
            $recipes = Recipe::where('user_id', (auth()->user() ? auth()->user()->id : ''))->paginate(10);
            // $message = isset(auth()->user()->id) ? 'homepage ' . auth()->user()->name . '<br>' .
            $message =   'These are recipes added by you. You can add more recipes to display your recipes here.';
        }
        // if we also compact the $keyboard then search item is seen in the blade file where the code is {{$keyword}}
        return view('recipes.index', compact('recipes', 'message', 'keyword'));
    }
    //-------------------------------------------------------------------------------------------------------------------------------
    // we dont perform model route binding here cuz we dont need value of a particular recipe but we need details of whole recipe.
    public function homepage(Request $request)
    {
        $latestRecords = Recipe::orderBy('created_at', 'desc')->limit(6)->get();
        // $topRatedRecipes = Recipe::whereHas('comments', function ($query) {
        //     $query->where('ratings', 5);
        // })->limit(10)->get();
        $topRatedRecipes = Recipe::whereHas('comments', fn ($query) => $query->where('ratings', 5))->limit(8)->get();
        $tag = $request->input('tag');
        $message = "Explore " . ucwords($tag) . " Recipes";
        if (!empty($tag)) {
            $query = Recipe::where('tags', 'LIKE', "%$tag%")->get();

            $recipes = Recipe::whereRaw('LOWER(tags) LIKE ?', '%' . strtolower($tag) . '%')->paginate(10);
        } else {
            //with('user') helps to bundle up query {} eager load }.  with(['user', 'favourites']) helps to fetch users and favourites data along with Recipe model. perform dd and see
            $recipes = Recipe::with(['user', 'favourites'])->inRandomOrder()->paginate(16);
        }
        return view('/homepage', compact('recipes', 'message', 'tag', 'latestRecords', 'topRatedRecipes'));
    }

    //-------------------------------------------------------------------------------------------------------------------------------

    public function store(StoreRecipe $request)
    {
        $ingredients = $request->data()['ingredients'];
        $directions = $request->data()['directions'];
        $tags = $request->data()['tags'];

        $user_id = auth()->user()->id;
        $array = $request->except(['image', 'ingredient', 'direction', 'tag']);
        $array['user_id'] = $user_id;
        $array['ingredients'] = json_encode($ingredients);
        $array['directions'] = json_encode($directions);
        $array['tags'] = json_encode($tags);

        // Upload and process the image
        $file_name = time() . '.' . request()->image->getClientOriginalExtension();

        if (request()->image->move(public_path('images'), $file_name)) {
            $recipes = Recipe::create($array);
            $recipes->update(['image' => $file_name]);
        }

        return redirect()->route('recipes.index')->with('success', 'New recipe has been added successfully.');
    }
    //-------------------------------------------------------------------------------------------------------------------------------
    public function edit(Recipe $recipe)
    {
        $ingredients = json_decode($recipe->ingredients);
        $directions = json_decode($recipe->directions);
        $tags = json_decode($recipe->tags);
        return view('recipes.edit', compact('recipe', 'ingredients', 'directions', 'tags'));  // input name is only for extracting data from view page.

    }
    //-------------------------------------------------------------------------------------------------------------------------------

    public function showByCategory($category)
    {

        $recipes = Recipe::where('tags', 'LIKE', "%$category%")->paginate(5);
        $message =  "Explore " . ucwords($category) . " Recipes";
        return view('/homepage', compact('recipes', 'message', 'category'));
    }
    //-------------------------------------------------------------------------------------------------------------------------------

    // this variable stores the user id of the routes url. represents the user ID passed in the URL of the route. u can use model route binding.
    public function userRecipes($user_id)
    {
        // Fetch the recipes associated with the user
        $recipes = Recipe::where('user_id', $user_id)->get();
        $user = User::where('id', $user_id)->firstorfail();
        $message = 'Recipe added by ' . $user->name;
        return view('recipes.index', compact('recipes', 'message'));
    }

    //-------------------------------------------------------------------------------------------------------------------------------
    // this is model route binding. $recipe consists of model of the id retrieved from route. This is only useful for one particular recipe and not whole recipe
    public function details(Recipe $recipe)
    {
        $ingredients = json_decode($recipe->ingredients);
        $directions = json_decode($recipe->directions);
        // we are writing here $recipe-> id because , it fetches model but we only need id
        $comments = Comment::with(['user', 'likes'])->where('recipe_id', $recipe->id);

        //if i dont use this i ll have error if the user is not logged in
        $existingReview = null;

        if (auth()->check()) {
            $userId = auth()->user()->id;

            $comments = $comments->where('user_id', '!=', $userId);
            $existingReview = Comment::with(['user', 'likes'])->where('recipe_id', $recipe->id)
                ->where('user_id', $userId)
                ->first();
        }

        $comments = $comments->get();

        return view('recipes.details', compact('recipe', 'ingredients', 'directions', 'existingReview', 'comments'));
    }


    // public function details($id)
    // {
    //     $recipe = Recipe::where('id', $id)->firstOrFail();
    //     $ingredients = json_decode($recipe->ingredients);
    //     $directions = json_decode($recipe->directions);

    //     $comments = Comment::where('recipe_id', $id)
    //         ->get();

    //     //if i dont use this i ll have error if the user is not logged in
    //     $existingReview = null;

    //     if (auth()->check()) {
    //         $userId = auth()->user()->id;

    //         $comments = $comments->where('user_id', '!=', $userId);
    //         $existingReview = Comment::where('recipe_id', $id)
    //             ->where('user_id', $userId)
    //             ->first();
    //     }

    //     $comments = $comments->all();

    //     return view('recipes.details', compact('recipe', 'ingredients', 'directions', 'existingReview', 'comments',));
    // }





    // public function details($id)
    // {
    //     $recipe = Recipe::where('id', $id)->firstOrFail();
    //     $ingredients = json_decode($recipe->ingredients);
    //     $directions = json_decode($recipe->directions);

    //     $userId = auth()->user()->id;

    //     $comments = Comment::where('recipe_id', $id)
    //         ->where('user_id', '!=', $userId) // Exclude current user's review
    //         ->get();

    //     $existingReview = Comment::where('recipe_id', $id)
    //         ->where('user_id', $userId) // Assuming you have a user_id column in the comments table
    //         ->first();

    //     return view('recipes.details', compact('recipe', 'ingredients', 'directions', 'existingReview', 'comments'));
    // }

    //-------------------------------------------------------------------------------------------------------------------------------


    public function create()
    {
        session()->forget('success');
        return view('recipes.create');
    }
    //-------------------------------------------------------------------------------------------------------------------------------



    // public function store(StoreRecipe $request)
    // {
    //     // $user_id = auth()->user()["id"];
    //     // $array = $request->all();
    //     $ingredients = json_encode($request->input('ingredient')); //input name is only for extracting data from view page.

    //     // echo implode("| ", $ingredients);
    //     $directions = json_encode($request->input('direction'));
    //     // echo implode("|", $directions);
    //     $tags = json_encode($request->input('tag'));

    //     $user_id = auth()->user()->id;
    //     $array = $request->except(['image', 'ingredient', 'direction', 'tag']);
    //     $array['user_id'] = $user_id;
    //     $array['ingredients'] = $ingredients;
    //     $array['directions'] = $directions;
    //     $array['tags'] = $tags; //table name
    //     // Upload and process the image
    //     $file_name = time() . '.' . request()->image->getClientOriginalExtension();

    //     if (request()->image->move(public_path('images'), $file_name)) {
    //         $recipes = Recipe::create($array);
    //         $recipes->update(['image' => $file_name]);
    //     }

    //     return redirect()->route('recipes.index')->with('success', 'New recipe has been added successfully.');
    // }
    // //-------------------------------------------------------------------------------------------------------------------------------
    public function storeReviews(StoreReviews $request)
    {
        $user_id = auth()->user()->id;
        // Get the recipe ID
        //recipe_id is shown from input type hidden.
        $recipe_id = $request->input('recipe_id');
        // Create a new comment record
        Comment::create([
            'comments' => $request->input('review'),
            'recipe_id' => $recipe_id,
            'user_id' => $user_id,
            'ratings' => $request->input('rating'),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Thank you for your reviews!');
    }

    // // public function storeReviews(StoreReviews $request)
    // {
    //     // Get the user ID
    //     $user_id = auth()->user()->id;

    //     // Create a new comment record
    //     Comment::create([
    //         'comments' => $request->input('review'),
    //         'recipe_id' => $request->input('recipe_id'),
    //         'user_id' => $user_id,
    //         'ratings' => $request->input('rating'),
    //     ]);

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Thank you for your reviews!');
    // }





    // public function show(Recipe $recipe)
    // {
    //     return view('recipes.show', compact('recipe'));
    // }

    //-------------------------------------------------------------------------------------------------------------------------------
    public function update(Recipe $recipe, Request $request)
    {
        $data = $request->except(['image', 'direction', 'ingredient', 'tag']);
        $data['ingredients'] = json_encode($request->input('ingredient'));
        $data['directions'] = json_encode($request->input('direction'));
        $data['tags'] = json_encode($request->input('tag'));


        if ($request->hasFile('image')) {
            $file_name = time() . '.' . $request->image->getClientOriginalExtension();
            if ($request->image->move(public_path('images'), $file_name)) {
                $data['image'] = $file_name;
            }
        }

        $recipe->update($data);

        return redirect()->route('recipes.index')->with('success', 'Recipe has been updated.');
    }

    //-------------------------------------------------------------------------------------------------------------------------------

    public function updateReviews(Comment $comment, StoreReviews $request)
    {
        // $data = $request->data();
        // "id" => 8
        // "recipe_id" => 18
        // "user_id" => 1
        // "ratings" => 3
        // "comments" => "This is just plain sushi"
        // "created_at" => "2023-06-13 08:03:42"
        // "updated_at" => "2023-06-13 08:03:42"

        $review_update_status = $comment->update($request->data());
        if ($review_update_status) {
            return redirect()->back()->with('success', 'Review has been updated.');
        }

        return redirect()->back()->with('error', 'Review has not been updated.');
    }

    //.................................................................................



    public function saveRecipe(Request $request)
    {
        $data = $request->only('recipe_id');
        $recipeId = $data['recipe_id'];

        $userId = auth()->user()->id;

        // Check if the recipe is already saved as a favorite
        $favorite = Favourite::where('user_id', $userId)->where('recipe_id', $recipeId)->first();

        if (!$favorite) {
            // Recipe is not saved as a favorite, so save it
            $favorite = new Favourite;
            $favorite->user_id = $userId;
            $favorite->recipe_id = $recipeId;
            $favorite->save();
            $message = 'Recipe saved successfully.';
        } else {
            // Recipe is already saved as a favorite, so delete it
            $favorite->delete();
            $message = 'Recipe removed from favorites.';
        }

        return redirect()->back()->with('success', $message);
    }



    public function savedRecipe()
    {
        $userId = auth()->user()->id;

        // Retrieve the saved recipes for the user
        $savedRecipes = Favourite::where('user_id', $userId)->get();

        return view('recipes.saved', compact('savedRecipes'));
    }

    // public function update(Recipe $recipe, Request $request)
    // {
    //     $ingredients = json_encode($request->input('ingredient'));
    //     $directions = json_encode($request->input('direction'));

    //     if ($request->hasFile('image')) {
    //         $file_name = time() . '.' . $request->image->getClientOriginalExtension();
    //         if ($request->image->move(public_path('images'), $file_name)) {
    //             $recipe->update([
    //                 'image' => $file_name,
    //                 'ingredients' => $ingredients,
    //                 'directions' => $directions,
    //             ]);
    //         }
    //     } else {
    //         $recipe->update([
    //             'ingredients' => $ingredients,
    //             'directions' => $directions,
    //         ]);
    //     }

    //     return redirect()->route('recipes.index')->with('success', 'Recipe has been updated.');
    // }

    // public function update(Recipe $recipe, Request $request)
    // {
    //     $file_name = time() . '.' . request()->image->getClientOriginalExtension();

    //     $recipe->update($request->except(['image', 'direction','ingredient']));

    //     $ingredients = json_encode($request->input('ingredient'));
    //     $directions = json_encode($request->input('direction'));

    //     if (request()->image->move(public_path('images'), $file_name)) {
    //         $recipe->update([
    //             'image' => $file_name,
    //             'ingredients' => $ingredients,
    //             'directions' => $directions,
    //         ]);
    //     }

    //     return redirect()->route('recipes.index')->with('success', 'Recipe has been updated.');
    // }

    //-------------------------------------------------------------------------------------------------------------------------------
    public function destroy(Recipe $recipe)
    {

        Favourite::where('recipe_id', $recipe->id)->delete();
        Comment::where('recipe_id', $recipe->id)->delete();
        File::delete(public_path('images/' . $recipe->image));

        $recipe->delete();

        return redirect('recipes')->with('success', 'Recipe has been deleted!');
    }
    //--------------------------------------------------------------------------------------------



    public function likeComment(Request $request, $commentId)
    {
        $userId = auth()->user()->id;

        // Check if the comment already has a like from the user
        $existingLike = Like::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->first();

        // If the like doesn't exist, create a new one
        if (!$existingLike) {
            $like = new Like();
            $like->comment_id = $commentId;
            $like->user_id = $userId;
            $like->save();
        } else {
            // If the like exists, delete it to unlike the comment
            $existingLike->delete();
        }
        return redirect()->back()->withAnchor('comment-' . $commentId); // anchor
    }
}
