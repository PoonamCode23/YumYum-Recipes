@extends('layouts.main')
@section('content')
    <main class ="container">
    <section>
    <form method="post" action="{{ route('recipes.update', $recipe->id)}}" enctype="multipart/form-data">

            @csrf
            @method('PUT')
            <div class="titlebar">
                <h1>Edit Recipe</h1>
            </div>
            <div class="form-group">
            <label for="formGroupExampleInput"><b>Recipe URL</b></label>
            <input type="text" class="form-control" name="url"  value="{{ $recipe->url}}">
        </div>
        <br>
        <div class="form-group">
            <label for="formGroupExampleInput"><b>Recipe Title</b></label>
            <input type="text" class="form-control" name="title" value="{{ $recipe->title}}">
        </div>
        <br>
        <div class="form-group">
            <label for="formGroupExampleInput2"><b>Description</b></label>
            <textarea cols="20" rows="10" name="description" id = "editor" class="form-control">{{ $recipe->description}}</textarea>{{--Value cannot be inserted inside textarea--}}
        </div>
        <br>
      
        <div class="form-group d-grid">
            <label for="formGroupExampleInput3" class="mb-3"><b>Add Image</b></label>
            <img src="{{ asset('images/'.$recipe->image) }}" alt="" class ="img-product mb-3"style="height:200px; width:200px; object-fit:cover;" id="file-preview"/>
            <input type="hidden" name="hidden_product_image" value="{{$recipe->image}}">
            <input type="file" name="image" accept="image/*" onchange="showFile(event)">
        </div>
        <br>
        <div class="form-group">
            <label for="formGroupExampleInput4"><b>Tags</b></label>
            <input type="text" class="form-control" name="tags" value="{{ $recipe->tags}}">
        </div>
        <br>
        <button type="submit" class="btn btn-success">Edit Recipe</button>
    </form>         
    </section>
    </main>
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
</script>
@endsection
