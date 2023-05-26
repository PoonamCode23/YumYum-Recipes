@extends('layouts.main')
@section('content')
    <main class="container border p-5 mb-2" style="max-width: 62%; margin-top: 40px;">
        <section>
            <form method="post" action="{{ route('recipes.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="titlebar mb-4">
                    <h3 style="color:green">Create Your Own Recipes</h3> 
                    <h5>Uploading personal recipes is easy! Add yours to your favorites, share with friends, family, or the Allrecipes community.</h5>
                </div>
             

                <div class="d-flex align-items-center">
                    <div class="left-side me-5" style="width: 62%;">
                        <div class="form-group mb-3">
                            <label class="fs-5" for="formGroupExampleInput ">Recipe Title</label>
                            <input type="text" class="form-control" name="title">
                            @if ($errors->has('title'))
                                @foreach ($errors->get('title') as $error)
                                    <span class="error-message">{{ $error }}</span>
                                @endforeach
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="fs-5" for="formGroupExampleInput2">Description</label>
                            <textarea style=" height:160px;" name="description" class="form-control" ></textarea>
                            @if ($errors->has('description'))
                                @foreach ($errors->get('description') as $error)
                                    <span class="error-message">{{ $error }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="d-grid">
                        <label class="mb-2 fs-5" for="formGroupExampleInput3">Add Image</label>
                        <label for="image-upload" class="image-upload-label">
                            <input id="image-upload" type="file" style="display:none" name="image" accept="image/*" onchange="showFile(event)">
                            <img src="https://placehold.co/200x200" alt="" class="img-thumbnail mb-2" style="max-height:250px" id="file-preview" />
                        </label>
                        @if ($errors->has('image'))
                            @foreach ($errors->get('image') as $error)
                                <span class="error-message">{{ $error }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
                <br>
               
                <div id="ingredientContainer">
                    <div class="form-group mb-3  ">
                        <label class="fs-5" for="formGroupExampleInput mb-3 ">Ingredients</label>
                        <input type="text" class="form-control " name="ingredient[]" placeholder="e.g. 2 cups flour">
                        @error('ingredient.0')
                        <span class="error-message"> {{$message}} </span>
                        @enderror
                        
                    </div>

                    <div class="form-group mb-3 ">
                        <input type="text" class="form-control" name="ingredient[]" placeholder="e.g. 1 spoon sugar">
                    </div>
                    @error('ingredient.1')
                    <span class="error-message">  {{$message}} </span>
                        @enderror
                </div>
                <button type="button" style="color:green" class="btn mb-3 " id="addIngredientBtn"> <i class="ph-bold ph-plus"></i>Add Ingredient</button>
                <br>
             
                <div id="directionContainer">
                    <div class="form-group mb-3 ">
                        <label class="fs-5"for="formGroupExampleInput">Directions</label>
                        <input type="text" class="form-control" name="direction[]" placeholder="e.g. Preheat oven to 200 degress.....">
                        @error('direction.0')
                        <span class="error-message">{{$message}} </span>
                        @enderror
            
                    </div>

                    <div class="form-group mb-3 ">
                        <input type="text" class="form-control" name="direction[]" placeholder="e.g. Mix all ingredients in a bowl.....">
                        @error('direction.1')
                        <span class="error-message"> {{$message}} </span>
                        @enderror
                    </div>
                </div>
                <button type="button" style="color:green" class="btn mb-3" id="addDirectionBtn"> <i class="ph-bold ph-plus"></i>Add Steps</button>
        
                <div class="form-group mb-3 ">
                    <div class="row">
                        <div class="col">
                            <label class="mb-2 fs-5" for="formGroupExampleInput3">Preparation Time (in mins)</label>
                            <input type="text" class="form-control" name="time_required" placeholder="e.g. 20 mins"> {{--name should same as column title--}}
                            @if ($errors->has('time_required'))
                                @foreach ($errors->get('time_required') as $error)
                                    <span class="error-message">{{ $error }}</span>
                                @endforeach
                            @endif
                        </div>

                        <div class="col">
                            <label class="mb-2 fs-5" for="formGroupExampleInput3">Servings</label>
                            <input type="text" class="form-control" name="servings" placeholder="e.g. 8">
                            @if ($errors->has('servings'))
                                @foreach ($errors->get('servings') as $error)
                                    <span class="error-message">{{ $error }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-4">Submit Recipe</button>
                </div>
                </form>
            </section>
    </main>
<style>
.error-message {
    color: red;
    font-size:14px;
}  
 .form-control{
height:55px;
 }
</style>


               
<script>
    function showFile(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var dataURL = reader.result;
            var output = document.getElementById('file-preview');
            output.src = dataURL;
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
