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
        $welcome_message = 'Search List';
        $keyword = $request->get('search');

        if (!empty($keyword)) {
            $recipes = Recipe::where('title', 'LIKE', "%$keyword%")->inRandomOrder()->get();
        } else {
            $recipes = Recipe::where('user_id', (auth()->user() ? auth()->user()->id : ''))->get();
            $welcome_message = isset(auth()->user()->id) ? 'Welcome ' . auth()->user()->name : '';
        }

        return view('recipes.index', compact('recipes', 'welcome_message'));
    }

    public function create()
    {
        session()->forget('success');
        return view('recipes.create');
    }

    public function store(StoreRecipe $request)
    {
        // $user_id = auth()->user()["id"];
        // $array = $request->all();

        $user_id = auth()->user()->id; // u can add hidden field  in create.blade.php but its secure here
        $array = $request->except('image');
        $array['user_id'] = $user_id;
        dd($array);

        // Upload and process the image
        $file_name = time() . '.' . request()->image->getClientOriginalExtension();

        if (request()->image->move(public_path('images'), $file_name)) {
            $recipes = Recipe::create($array);
            $recipes->update(['image' => $file_name]);
        }

        return redirect()->route('recipes.index')->with('success', 'New recipe has been added successfully.');
    }

    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Recipe $recipe, Request $request)
    {
        $file_name = time() . '.' . request()->image->getClientOriginalExtension();

        $recipe->update($request->except('image'));
        if (request()->image->move(public_path('images'), $file_name)) {
            $recipe->update(['image' => $file_name]);
        }

        return redirect()->route('recipes.index')->with('success', 'Recipe has been updated.');
        // $item->update([
        //     'name' => 'poonam'
        // ]);
    }

    public function destroy(Recipe $recipe)
    {
        File::delete(public_path('images/' . $recipe->image));
        $recipe->delete();

        return redirect('recipes')->with('success', 'Recipe has been deleted!');
    }
}
