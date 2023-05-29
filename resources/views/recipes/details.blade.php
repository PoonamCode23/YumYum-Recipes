@extends ('layouts.main')
@section('content')
  <div class="container">
   
        <img src="{{ asset('images/'.$recipe->image) }}" alt="Recipe Image" class="image-banner" >
      </div>

     


<div class="receipe-content-area">
            <div class="container mt-3">
             <h4 style="text-align:justify;"> {{$recipe->description}}</h4>
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="receipe-headline my-5">
                            <span>{{ $recipe->created_at }}</span>
                            <h2>{{ $recipe->title }}</h2>
                            <div class="receipe-duration ">
                               <h5> Prep: {{ $recipe->time_required }}</h5>
                                <h5>Yields:{{$recipe->servings}}</h5>
                            </div>
                        </div>
                    </div>

                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="step d-flex">
                         <ol>
                            @foreach ($directions as $direction)
                             <li><p>{{ old('$direction', $direction ?? '')}}</p></li>
                             @endforeach
                            </ol>
                        </div>
                    </div>

                    <!-- Ingredients -->
                    <div class="col-12 col-lg-4">
                        <div class="ingredients">
                            <h3>Ingredients</h3>

                            @foreach ($ingredients as $ingredient)
                            <div class="custom-checkbox">
                                <input type="checkbox" class="input" id="customCheck1">
                               <label class="label" for="customCheck1">{{ $ingredient }}</label>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
@endsection

<style>
.image-banner{
    width:100%;
  height:50%;
  object-fit:cover;
  margin-bottom: 30px;
}
.receipe-duration {
  border-left: 3px solid #40ba37;
  padding: 15px; }
  
 .input {
    width: 20px;
    height: 20px;
}
.step{
    font-size:25px;   
}
.label{
font-size:25px;
}
.custom-checkbox .input:checked + .label {
  color: green;
}

</style>