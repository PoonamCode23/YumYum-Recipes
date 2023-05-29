@extends('layouts.main')
@section('content')
<main class="container">
       
                    <div class="row">
                       
                        @foreach($recipes as $recipe)
                        <div class="col-md-3"><!--display screen size-->
                            <div class="card mb-3">
                                <img class="card-img-top" style="width: 100% ; height: 45%; object-fit: content;" src="{{asset('images/'. $recipe->image)}}" alt="Card image cap">{{--object-fit property to ensure that the image fills the available space while maintaining its aspect ratio.--}}
                                <div class="card-body">
                                    <h4 class="card-title receip-title">{{ $recipe->title }}</h4>
                                    <p class="card-text">{{$recipe->description }}</p>
                                    <a href="{{ route('recipes.details', $recipe->id) }}" class="btn btn-light position-absolute start-1 bottom-0 mb-3">View Details</a>
                                    @auth
                                    @if(auth()->user()->id == $recipe->user_id)
                                    <a href="{{ route('recipes.edit', $recipe->id) }}"  style=" text-decoration: none; position: absolute; bottom: 10px;  right: 10px;"> <i class="ph-bold ph-pencil"></i></a>
                                    <form method="post" action="{{ route('recipes.destroy', $recipe->id) }}" >
                                    @method('delete')
                                    @csrf
                                     <button  type="submit" onclick="deleteConfirm(event)" class="btn" style=" color: red; position: absolute; bottom: 4px;  right: 30px;"> <i class="ph-bold ph-trash"></i> </button>
                                     </form>
                                    @endif

                                   
                                     @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach    
                       </div>   
            </div>
</main>
@endsection



