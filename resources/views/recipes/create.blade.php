@extends('layouts.main')
@section('content')
<div class="container">
    <main class="box border mx-auto p-5  mb-1"> <!--mx-auto for aligning items to center-->
        <section>
            <form method="post" action="{{ route('recipes.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="titlebar mb-4">
                    <h3 style="color:coral">Create Your Own Recipes</h3>
                    <h5>Uploading personal recipes is easy! Add yours to your favorites, share with friends, family, or the Allrecipes community.</h5>
                </div>


                <div class="d-flex align-items-center">
                    <div class="left-side me-5" style="width: 62%;">
                        <div class="form-group mb-3">
                            <label class="fs-5" for="formGroupExampleInput ">Recipe Title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                            @foreach ($errors->get('title') as $error)
                            <span class="error-message">{{ $error }}</span>
                            @endforeach
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="fs-5" for="formGroupExampleInput2">Description</label>
                            <textarea style=" height:160px;" name="description" class="form-control"></textarea>
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

                <div id="ingredientcontainer">
                    <div class="form-group mb-3  ">
                        <label class="fs-5" for="formGroupExampleInput mb-3 ">Ingredients</label>
                        <input type="text" class="form-control " name="ingredient[]" placeholder="e.g. 2 cups flour">
                        {{--@error('ingredient.0')
                    <span class="error-message"> {{$message}} </span>
                        @enderror--}}

                    </div>

                    <div class="form-group mb-3 ">
                        <input type="text" class="form-control" name="ingredient[]" placeholder="e.g. 1 spoon sugar">
                    </div>
                    {{--@error('ingredient.1')
                <span class="error-message"> {{$message}} </span>
                    @enderror--}}

                </div>
                <button type="button" style="color:coral" class="btn mb-3 " id="addIngredientBtn"> <i class="ph-bold ph-plus"></i>Add Ingredient</button>
                <br>

                <div id="directioncontainer">
                    <div class="form-group mb-3 ">
                        <label class="fs-5" for="formGroupExampleInput">Directions</label>
                        <input type="text" class="form-control" name="direction[]" placeholder="e.g. Preheat oven to 200 degress....." maxlength="50">
                        {{-- @error('direction.0')
                    <span class="error-message">{{$message}} </span>
                        @enderror--}}

                    </div>

                    <div class="form-group mb-3 ">
                        <input type="text" class="form-control" name="direction[]" placeholder="e.g. Mix all ingredients in a bowl.....">
                        {{-- @error('direction.1')
                    <span class="error-message"> {{$message}} </span>
                        @enderror--}}
                    </div>
                </div>
                <button type="button" style="color:coral" class="btn mb-3" id="addDirectionBtn"> <i class="ph-bold ph-plus"></i>Add Steps</button>

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
                </div>

                <div id="tagcontainer">
                    <div class="form-group mb-3  ">
                        <label class="fs-5" for="formGroupExampleInput mb-3 ">Tags</label>
                        <input type="text" class="form-control " name="tag[]" placeholder="e.g. gluten-free">
                    </div>
                </div>

                <button type="button" style="color:coral" class="btn mb-3 " id="addTagBtn"> <i class="ph-bold ph-plus"></i>Add Tags</button>

                <div>
                    <button type="button" class="button btn-success mt-4" onclick="reset()">Cancel</button>


                    <button type=" submit" class="button btn-success mt-4">Submit Recipe</button>

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

    .error-message {
        color: red;
        font-size: 14px;
    }


    .button {
        background-color: coral;
        border: none;
        border-radius: 7px;
        padding: 7px;

    }


    body {
        background-image: url("{{ asset('food.png') }}");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-position: center;

    }

    .ingredient-input {
        width: 95%;
    }

    .direction-input {
        width: 95%;
    }

    .tag-input {
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


    document.getElementById('addTagBtn').addEventListener('click', function() {
        var container = document.getElementById('tagcontainer');
        var newTagField = document.createElement('div');
        newTagField.classList.add('form-group', 'mb-3');

        var inputWrapper = document.createElement('div');
        inputWrapper.classList.add('input-wrapper');

        var input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('class', 'form-control tag-input');
        input.setAttribute('name', 'tag[]');
        input.setAttribute('placeholder', 'Add another step');
        inputWrapper.appendChild(input);

        var deleteIcon = document.createElement('i');
        deleteIcon.classList.add('ph', 'ph-x');
        deleteIcon.style.color = 'red';
        deleteIcon.style.cursor = 'pointer';
        deleteIcon.addEventListener('click', function() {
            container.removeChild(newTagField);
        });
        inputWrapper.appendChild(deleteIcon);

        newTagField.appendChild(inputWrapper);
        container.appendChild(newTagField);
    });


    function reset() {
        var form = document.querySelector('form');
        form.reset();
    }
</script>
@endsection