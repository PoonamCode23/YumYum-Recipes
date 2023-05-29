@extends('layouts.main')
@section('content')
<main class="container border p-5 mb-2" style="max-width: 62%;">
    <section>
        <form method="post" action="{{ route('recipes.update', $recipe->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="titlebar mb-4">
                <h1>You Can Edit Your Recipe Here.</h1>
            </div>
            <div class="d-flex align-items-center">
                <div class="left-side me-5" style="width: 62%;">
                    <div class="form-group mb-3">
                        <label class="fs-5" for="formGroupExampleInput">Recipe Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $recipe->title }}">
                    </div>

                    <div class="form-group mb-3">
                        <label class="fs-5" for="formGroupExampleInput2">Description</label>
                        <textarea style="height: 160px;" name="description" class="form-control ">{{ $recipe->description }}</textarea>
                    </div>
                 </div>

                <div class="d-grid">
                    <label class="mb-2 fs-5" for="formGroupExampleInput3">Add Image</label>
                    <label for="image-upload" class="image-upload-label">
                        <img src="{{ asset('images/'.$recipe->image) }}" alt="" class="img-thumbnail mb-2" style="max-height: 250px" id="file-preview" />
                        <input type="hidden" name="hidden_product_image" value="{{ $recipe->image }}">
                        <input type="file" name="image" accept="image/*" onchange="showFile(event)">
                    </label>
                </div>
            </div>

            <div id="ingredientContainer">
                <div class="form-group mb-3">
                    <label class="fs-5" for="formGroupExampleInput mb-3">Ingredients</label>
                    @foreach($ingredients as $ingredient)
                    <input type="text" class="form-control" value="{{$ingredient }}" name="ingredient[]" placeholder="e.g. 2 cups flour"> 

                    @endforeach
                </div>

               
            </div>
            <button type="button" style="color: green" class="btn mb-3" id="addIngredientBtn"><i class="ph-bold ph-plus"></i>Add Ingredient</button>

            <div id="directionContainer">
                <div class="form-group mb-3">
                    <label class="fs-5" for="formGroupExampleInput">Directions</label>

                    @foreach($directions as $direction)
                    <input type="text" class="form-control" name="direction[]" value="{{$direction }}" placeholder="e.g. Preheat oven to 200 degrees.....">
                    @endforeach
                </div>

                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="direction[]" placeholder="e.g. Mix all ingredients in a bowl.....">
                </div>
            </div>
            <button type="button" style="color: green" class="btn mb-3" id="addDirectionBtn"><i class="ph-bold ph-plus"></i>Add Steps</button>

            <div class="form-group mb-3">
                <div class="row">
                    <div class="col">
                        <label class="mb-2 fs-5" for="formGroupExampleInput3">Preparation Time (in mins)</label>
                        <input type="text" class="form-control" name="time_required" value="{{ $recipe->time_required }}" placeholder="e.g. 20 mins"> {{-- name should be the same as the column title --}}
                    </div>

                    <div class="col">
                        <label class="mb-2 fs-5" for="formGroupExampleInput3">Servings</label>
                        <input type="text" class="form-control" name="servings" value="{{ $recipe->servings }}" placeholder="e.g. 8">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Edit Recipe</button>
        </form>
    </section>
</main>
<style> 
 .form-control{
height:55px;
 }
</style>
                       

    <script>
       function showFile(event){
            var input= event.target;
            var reader= new FileReader();
            reader.onload=function(){
                var dataURL=reader.result;
                var output=document.getElementById ('file-preview');
                output.src=dataURL;
            };
            reader.readAsDataURL(input.files[0]);
            }
            document.getElementById('addIngredientBtn').addEventListener('click', function () {
            var container = document.getElementById('ingredientContainer');
            var newIngredientField = document.createElement('div');
            newIngredientField.classList.add('form-group');
            var input = document.createElement('input');
            input.setAttribute('type', 'text');
            input.setAttribute('class', 'form-control');
            input.setAttribute('name', 'ingredient[]');
            input.setAttribute('placeholder', 'Add another ingredient');

            newIngredientField.appendChild(input);
            container.appendChild(newIngredientField);
            
            });

            document.getElementById('addDirectionBtn').addEventListener('click', function () {
            var container = document.getElementById('directionContainer');
            var newDirectionField = document.createElement('div');
            newDirectionField.classList.add('form-group');
            var input = document.createElement('input');
            input.setAttribute('type', 'text');
            input.setAttribute('class', 'form-control');
            input.setAttribute('name', 'direction[]');
            input.setAttribute('placeholder', 'Add another steps');

            newDirectionField.appendChild(input);
            container.appendChild(newDirectionField);
            });
    </script>
@endsection
