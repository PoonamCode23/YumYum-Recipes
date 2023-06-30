@extends('layouts.main')
@section('content')
<div class="container">
    <main class="box border mx-auto p-5  mb-1"> <!--mx-auto for aligning items to center-->
        <section>
            <form method="post" action="{{ route('recipes.update', $recipe->id) }}" enctype="multipart/form-data"><!-- when passing parameter in the {} url in routes using get method, mention the value of id in the action too-->
                @csrf
                @method('PUT')
                <div class="titlebar mb-4">
                    <h3 style="color:coral">You Can Edit Your Recipe Here.</h3>
                </div>
                <div class=" d-flex align-items-center">
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

                <div id="ingredientcontainer">
                    <div class="form-group">
                        <label class="fs-5" for="formGroupExampleInput">Ingredients</label>
                        @foreach($ingredients as $ingredient)
                        <input type="text" class="form-control mb-3" value="{{$ingredient }}" name="ingredient[]" placeholder="e.g. 2 cups flour">
                        @endforeach
                    </div>
                </div>
                <button type="button" style="color:coral" class="btn mb-3 " id="addIngredientBtn"> <i class="ph-bold ph-plus"></i>Add Ingredient</button>


                <div id="directioncontainer">
                    <div class="form-group">
                        <label class="fs-5" for="formGroupExampleInput">Directions</label>

                        @foreach($directions as $direction)
                        <input type="text" class="form-control mb-3" name="direction[]" value="{{$direction }}" placeholder="e.g. Preheat oven to 200 degrees.....">
                        @endforeach
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="direction[]" placeholder="e.g. Mix all ingredients in a bowl.....">
                    </div>
                </div>
                <button type="button" style="color:coral" class="btn mb-3" id="addDirectionBtn"> <i class="ph-bold ph-plus"></i>Add Steps</button>

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
                    <div class="text-end">
                        <button type=" submit" class="button btn-success mt-4">Update Recipe</button>

                    </div>
                </div>

            </form>
        </section>
    </main>
</div>
<style>
    .box {
        width: 60%;
        background-color: white;
    }

    body {
        background-image: url("{{ asset('backgroundimg.avif') }}");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-position: center;

    }


    .button {
        background-color: coral;
        border: none;
        border-radius: 7px;
        padding: 7px;
    }

    .ingredient-input {
        width: 95%;
    }

    .direction-input {
        width: 95%;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        font-size: 14px;
    }
</style>


<script>
    function showFile(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function() {
            var dataURL = reader.result;
            var output = document.getElementById('file-preview');
            output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
    }
    document.getElementById('addIngredientBtn').addEventListener('click', function() {
        var container = document.getElementById('ingredientcontainer');
        var newIngredientField = document.createElement('div');
        newIngredientField.classList.add('form-group', 'mb-3');

        var inputWrapper = document.createElement('div');
        inputWrapper.classList.add('input-wrapper');

        var input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('class', 'form-control ingredient-input');
        input.setAttribute('name', 'ingredient[]');
        input.setAttribute('placeholder', 'Add another ingredient');
        inputWrapper.appendChild(input);

        var deleteIcon = document.createElement('i');
        deleteIcon.classList.add('ph', 'ph-x');
        deleteIcon.style.color = 'red';
        deleteIcon.style.cursor = 'pointer';
        deleteIcon.addEventListener('click', function() {
            container.removeChild(newIngredientField);
        });
        inputWrapper.appendChild(deleteIcon);

        newIngredientField.appendChild(inputWrapper);

        container.appendChild(newIngredientField);
    });




    document.getElementById('addDirectionBtn').addEventListener('click', function() {
        var container = document.getElementById('directioncontainer');
        var newDirectionField = document.createElement('div');
        newDirectionField.classList.add('form-group', 'mb-3');

        var inputWrapper = document.createElement('div');
        inputWrapper.classList.add('input-wrapper');

        var input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('class', 'form-control direction-input');
        input.setAttribute('name', 'direction[]');
        input.setAttribute('placeholder', 'Add another step');
        inputWrapper.appendChild(input);

        var deleteIcon = document.createElement('i');
        deleteIcon.classList.add('ph', 'ph-x');
        deleteIcon.style.color = 'red';
        deleteIcon.style.cursor = 'pointer';
        deleteIcon.addEventListener('click', function() {
            container.removeChild(newDirectionField);
        });
        inputWrapper.appendChild(deleteIcon);

        newDirectionField.appendChild(inputWrapper);
        container.appendChild(newDirectionField);
    });
</script>
@endsection