<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRecipe;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        if (!empty($keyword)) {
            $recipes = Recipe::where('title', 'LIKE', "%$keyword%")->inRandomOrder()->get();
            $message = count($recipes) > 0 ? "Search List for '$keyword'" : "No results found for '$keyword'. Please try searching other recipes.";
        } else {
            $recipes = Recipe::where('user_id', (auth()->user() ? auth()->user()->id : ''))->get();
            $welcome_message = isset(auth()->user()->id) ? 'Welcome ' . auth()->user()->name : '';
        }

        return view('recipes.index', compact('recipes', 'message'));
    }
    //-------------------------------------------------------------------------------------------------------------------------------
    public function welcome(Recipe $recipe)
    {
        $recipes = Recipe::inRandomOrder()->get();

        return view('/welcome', compact('recipes'));
    }




    //-------------------------------------------------------------------------------------------------------------------------------
    public function edit(Recipe $recipe)
    {
        $ingredients = json_decode($recipe->ingredients);
        $directions = json_decode($recipe->directions);
        return view('recipes.edit', compact('recipe', 'ingredients', 'directions'));  // table name, input name is only for extracting data from view page.

    }
    //-------------------------------------------------------------------------------------------------------------------------------


    public function details($id)  //need to pass id for edit view details.
    {
        $recipe = Recipe::where('id', $id)->firstorfail();
        $ingredients = json_decode($recipe->ingredients);
        $directions = json_decode($recipe->directions);
        return view('recipes.details', compact('recipe', 'ingredients', 'directions')); // json should be decoded here too to display ingredients and
    }
    //-------------------------------------------------------------------------------------------------------------------------------


    public function create()
    {
        session()->forget('success');
        return view('recipes.create');
    }
    //-------------------------------------------------------------------------------------------------------------------------------


    public function store(StoreRecipe $request)
    {
        // $user_id = auth()->user()["id"];
        // $array = $request->all();
        $ingredients = json_encode($request->input('ingredient')); //input name is only for extracting data from view page.

        // echo implode("| ", $ingredients);
        $directions = json_encode($request->input('direction'));
        // echo implode("|", $directions);
        $user_id = auth()->user()->id;
        $array = $request->except(['image', 'ingredient', 'direction']);
        $array['user_id'] = $user_id;
        $array['ingredients'] = $ingredients;
        $array['directions'] = $directions; //table name
        // Upload and process the image
        $file_name = time() . '.' . request()->image->getClientOriginalExtension();

        if (request()->image->move(public_path('images'), $file_name)) {
            $recipes = Recipe::create($array);
            $recipes->update(['image' => $file_name]);
        }

        return redirect()->route('recipes.index')->with('success', 'New recipe has been added successfully.');
    }
    //-------------------------------------------------------------------------------------------------------------------------------


    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }
    //-------------------------------------------------------------------------------------------------------------------------------
    public function update(Recipe $recipe, Request $request)
    {
        $data = $request->except(['image', 'direction', 'ingredient']);
        $data['ingredients'] = json_encode($request->input('ingredient'));
        $data['directions'] = json_encode($request->input('direction'));

        if ($request->hasFile('image')) {
            $file_name = time() . '.' . $request->image->getClientOriginalExtension();
            if ($request->image->move(public_path('images'), $file_name)) {
                $data['image'] = $file_name;
            }
        }

        $recipe->update($data);

        return redirect()->route('recipes.index')->with('success', 'Recipe has been updated.');
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
        File::delete(public_path('images/' . $recipe->image));
        $recipe->delete();

        return redirect('recipes')->with('success', 'Recipe has been deleted!');
    }
}
