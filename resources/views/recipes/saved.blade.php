@extends ('layouts.main')
@section('content')
<main class="container">
    <h1>Saved Recipes</h1>

    @if ($savedRecipes->isEmpty())
    <p>You haven't saved any recipes yet! Click on heart icon of your favourite recipe to save it here.</p>
    @else

    <div class="row">
        @foreach($savedRecipes as $recipe)
        <div class="col-md-3">
            <div class="card mb-3">
                <img class="card-img-top" style="width: 100%; height: 45%; object-fit: cover;" src="{{ asset('images/'.$recipe->recipe->image) }}" alt="image">
                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        <h4 class="card-title recipe-title">{{ $recipe->recipe->title }}</h4>
                        <form method="post" action="{{ route('favourites.save', $recipe->recipe->id) }}">
                            @csrf
                            <input type="hidden" name="recipe_id" value="{{$recipe->recipe->id}}" />

                            <button type="submit" class="saved-icon" data-bs-placement=" top" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Unsave">
                                <i class="ph-fill ph-heart"></i></a>
                            </button>


                        </form>
                    </div>
                    <p class="card-text">{{ $recipe->recipe->description }}</p>
                    <p>Recipe by <a href="{{ route('recipes.user', $recipe->recipe->user_id) }}" class="text">{{ $recipe->recipe->user->name ?? 'Unknown' }}</a></p>
                    <a href="{{ route('recipes.details', $recipe->recipe->id) }}" class="button start-1 bottom-0 mb-3">Full Recipe</a>
                    @auth
                    @if(auth()->user()->id == $recipe->recipe->user_id)
                    <a href="{{ route('recipes.edit', $recipe->recipe->id) }}" style="text-decoration: none; position: absolute; bottom: 10px; right: 10px;"><i class="ph-bold ph-pencil"></i></a>
                    <form method="post" action="{{ route('recipes.destroy', $recipe->recipe->id) }}" id="deleterecipe">
                        @method('delete')
                        @csrf
                        <button type="submit" onclick="deleteConfirm(event)" class="btn" style="color: red; position: absolute; bottom: 4px; right: 30px;"><i class="ph-bold ph-trash"></i></button>
                    </form>
                    @endif
                    @endauth

                </div>
            </div>
        </div>
        @endforeach
    </div>


</main>

@endif

@if($message = Session::get('success'))
<script type="text/javascript">
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'success',
        title: '{{ $message}}'
    });
</script>
@endif

<style>
    .button {
        color: black;
        background-color: coral;
        position: absolute;
        text-decoration: none;
        transition: box-shadow 0.4s ease;
        padding: 5px 15px;
        border-radius: 5px;
    }

    .button:hover {
        box-shadow: 3px 4px 6px rgba(255, 127, 80, 0.8);
    }


    .saved-icon {
        font-size: 25px;
        color: coral;
        border: none;
        background-color: transparent;
    }

    .ph-fill {
        color: red;
    }

    .custom-tooltip {
        --bs-tooltip-bg: red;
    }
</style>
@endsection