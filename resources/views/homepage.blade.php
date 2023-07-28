@extends('layouts.main')
@section('content')
<main class="container" style="margin-top:124px;">
  @if((request()->route()->uri == '/') && empty($tag))
  <div class="latest-recipe">
    <h1 class="mb-3">Our Recent Recipes</h1>
    <div class="row">

      @foreach($latestRecords as $latestRecord)
      <div class="col-md-2"><!-- 12/4=4 items -->
        <div class="card mb-3" style="border: transparent !important; box-shadow: none !important;">
          <a href="{{ route('recipes.details', $latestRecord->id) }}" style="display: inline-block; border-radius: 90%; overflow: hidden;">
            <div class="image-wrapper">
              <img class="card-img-top" style="width: 100%; height: 100%; object-fit: cover;" src="{{ asset('images/' . $latestRecord->image) }}" alt="Card image cap">
            </div>
          </a>
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h5 class="card-title receip-title mb-3 mx-auto">{{ $latestRecord->title }}</h5>
            </div>
            <p>Recipe by <a href="{{ route('recipes.user', $latestRecord->user_id) }}" class="text">{{ $latestRecord->user->name ?? 'Unknown' }}</a></p> <!-- while clicking this name route url is passed as specified in the web.php---><!-- $recipe->user_id helps to pass parameter to the route which in turn passes  it to controller.-->
          </div>
        </div>
      </div>

      @endforeach
    </div>
  </div>

  <div class="latest-recipe">
    <h1 class="mb-3">Top-Rated Recipes</h1>
    <div class="row">
      @foreach($topRatedRecipes as $topRatedRecipe)
      <div class="col-md-3">
        <div class="card mb-3" style="border: transparent !important; box-shadow: none !important;">
          <a href="{{ route('recipes.details', $topRatedRecipe->id) }}" style="display: inline-block; border-radius: 90%; overflow: hidden;">
            <div class="image-wrapper">
              <img class="card-img-top" style="width: 100%; height: 100%; object-fit: cover;" src="{{ asset('images/' . $topRatedRecipe->image) }}" alt="Card image cap">
            </div>
          </a>

          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h4 class="card-title receip-title mb-3 mx-auto">{{ $topRatedRecipe->title }}</h4>
            </div>
            @php
            $averageStarRating = round(number_format(round($topRatedRecipe->comments->avg('ratings'), 1), 1));
            $integerPart = floor($averageStarRating);
            $decimalPart = $averageStarRating - $integerPart;
            @endphp

            @if($averageStarRating >0)

            <div class="col-6 mx-auto">
              <div class="rating mb-3" id="star-ratings">
                <label for="star5" class="star1 {{ $averageStarRating >= 5? 'checked' : '' }} " data-rating="5">
                  <i class="ph-fill ph-star"></i>
                </label>
                <label for="star4" class="star1 {{ $averageStarRating >= 4? 'checked' : '' }}" data-rating="4">
                  <i class="ph-fill ph-star"></i>
                </label>
                <label for="star3" class="star1 {{ $averageStarRating>= 3? 'checked' : '' }} " data-rating="3">
                  <i class="ph-fill ph-star"></i>
                </label>
                <label for="star2" class="star1 {{ $averageStarRating >= 2? 'checked' : '' }} " data-rating="2">
                  <i class="ph-fill ph-star"></i>
                </label>
                <label for="star1" class="star1 {{ $averageStarRating >= 1 ? 'checked' : '' }} " data-rating="1">
                  <i class="ph-fill ph-star"></i>
                </label>
              </div>
            </div>

            @endif
            <p>
              @if ($topRatedRecipe->comments->count() > 0)
              {{ $topRatedRecipe->comments->count() }} Reviews
              @endif
            </p>
            <p>Recipe by <a href="{{ route('recipes.user', $topRatedRecipe->user_id) }}" class="text">{{ $topRatedRecipe->user->name ?? 'Unknown' }}</a></p> <!-- while clicking this name route url is passed as specified in the web.php---><!-- $recipe->user_id helps to pass parameter to the route which in turn passes  it to controller.-->
          </div>
        </div>
      </div>

      @endforeach
    </div>
  </div>

  @endif

  <div class="row">
    @if (!empty($tag) || !empty($category))
    <div class="category-message">
      {{$message}}
    </div>
    @endif
    @if((request()->route()->uri == '/'))
    <div class="latest-recipe">
      <h1 class="mb-3">Other Recipes</h1>
    </div>
    @endif
    @foreach($recipes as $recipe)
    <div class="col-md-3"><!-- 12/4=4 items -->

      <div class="card mb-3">
        <img class="card-img-top" style="width: 100%; height: 45%; object-fit: cover;" src="{{ asset('images/' . $recipe->image) }}" alt="Card image cap"><!-- Object-fit property to ensure that the image fills the available space while maintaining its aspect ratio -->
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <h4 class="card-title receip-title mb-3 ">{{ $recipe->title }}</h4>
            @if(auth()->check() && $recipe->favourites->contains('user_id', auth()->user()->id))
            <form method="post" action="{{ route('favourites.save') }}" class="text-decoration-none">
              @csrf
              <input type="hidden" name="recipe_id" value="{{ $recipe->id }}" />
              <button type="submit" class="saved-icon" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Unsave">
                <i class="ph-fill ph-heart"></i>
              </button>
            </form>
            @else
            <form method="post" action="{{ route('favourites.save', $recipe->id) }}">
              @csrf
              <input type="hidden" name="recipe_id" value="{{ $recipe->id }}" />
              <button type="submit" class="save-button" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Save">
                <i class="ph-bold ph-heart"></i>
              </button>
            </form>
            @endif
          </div>

          <div class="d-flex justify-content-between">
            @php
            $averageStarRating = round(number_format(round($recipe->comments->avg('ratings'), 1), 1));
            $integerPart = floor($averageStarRating);
            $decimalPart = $averageStarRating - $integerPart;
            @endphp

            @if($averageStarRating > 0)

            <div class="col-6">
              <div class="rating mb-3" id="star-ratings">
                <label for="star5" class="star1 {{ $averageStarRating >= 5? 'checked' : '' }} " data-rating="5">
                  <i class="ph-fill ph-star"></i>
                </label>
                <label for="star4" class="star1 {{ $averageStarRating >= 4? 'checked' : '' }}" data-rating="4">
                  <i class="ph-fill ph-star"></i>
                </label>
                <label for="star3" class="star1 {{ $averageStarRating>= 3? 'checked' : '' }} " data-rating="3">
                  <i class="ph-fill ph-star"></i>
                </label>
                <label for="star2" class="star1 {{ $averageStarRating >= 2? 'checked' : '' }} " data-rating="2">
                  <i class="ph-fill ph-star"></i>
                </label>
                <label for="star1" class="star1 {{ $averageStarRating >= 1 ? 'checked' : '' }} " data-rating="1">
                  <i class="ph-fill ph-star"></i>
                </label>
              </div>
            </div>

            @endif


            <p>
              @if ($recipe->comments->count() > 0)
              {{ $recipe->comments->count() }} Reviews
              @endif
            </p>

          </div>
          <p class="card-text">
            @php
            $words = explode(' ', $recipe->description);
            $maxWords = 17;
            $displayDescription = count($words) > $maxWords ? implode(' ', array_slice($words, 0, $maxWords)) . '...' : $recipe->description;
            echo $displayDescription;
            @endphp
          </p>


          <p>Recipe by <a href="{{ route('recipes.user', $recipe->user_id) }}" class="text">{{ $recipe->user->name ?? 'Unknown' }}</a></p> <!-- while clicking this name route url is passed as specified in the web.php---><!-- $recipe->user_id helps to pass parameter to the route which in turn passes  it to controller.-->
          <div class="mt-5 mb-5 d-flex flex-wrap">

            @php
            $tags = json_decode($recipe->tags);
            @endphp
            @if (!is_null($tags))
            @foreach ($tags as $tag)
            <form method="GET" action="{{ route('homepage') }}"><!--use this form inside for each loop or else data will be submitted as many as tags are available.-->
              @csrf
              <input type="hidden" name="tag" value="{{ $tag }}">
              <button type="submit" class="tags">{{ $tag }}</button>
            </form>
            @endforeach
            @endif


          </div>

          <a href="{{ route('recipes.details', $recipe->id) }}" class="button start-1 bottom-0 mb-3">Full Recipe</a>

          @auth
          @if(auth()->user()->id == $recipe->user_id)
          <a href="{{ route('recipes.edit', $recipe->id) }}" style="text-decoration: none; position: absolute; bottom: 10px; right: 10px;"><i class="ph-bold ph-pencil"></i></a>
          <form method="post" action="{{ route('recipes.destroy', $recipe->id) }}" id="deleterecipe-{{$recipe->id}}">
            @method('delete')
            @csrf
            <button type="submit" onclick="deleteConfirm(event,{{$recipe->id}})" class="btn" style=" color: red; position: absolute; bottom: 4px;  right: 30px;"> <i class="ph-bold ph-trash"></i> </button>
          </form>
          @endif
          @endauth
        </div>
      </div>
    </div>
    @endforeach
    <div class="pagination">
      {{ $recipes->links() }} <!--see app\provider\appserviceprovider-->
    </div>

  </div>
</main>

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

<script>
  window.deleteConfirm = function(e, recipe_id) {
    e.preventDefault();
    var form = document.getElementById('deleterecipe-' + recipe_id);
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    })
  }
</script>



<style>
  .button {
    color: white;
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

  .latest-recipe {
    text-align: center;
    font-weight: bold;
  }

  .latest-recipe h1 {
    position: relative;
  }

  .latest-recipe h1::before {
    content: "";
    position: absolute;
    border-top: 2px solid #ccc;
    width: 28rem;
    height: 2px;
    display: block;
    left: 0rem;
    top: 54%;
  }

  .latest-recipe h1::after {
    content: "";
    position: absolute;
    border-top: 2px solid #ccc;
    width: 28rem;
    height: 2px;
    display: block;
    right: 0rem;
    top: 54%;
  }

  .image-wrapper {
    width: 100%;
    height: 190px;
    border-radius: 50%;
    overflow: hidden;
  }

  .image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .category-message {
    font-size: 30px;
    font-weight: 500;
    text-align: center;
    margin-bottom: 25px;
  }

  .card {
    transition: box-shadow 0.4s ease;
    border: 1px solid wheat !important;
  }

  .card:hover {
    box-shadow: 3px 4px 6px rgba(255, 127, 80, 0.8);

  }

  .text {
    font-style: italic;
    font-size: 14px;
    text-decoration: none;
  }

  .text:hover {
    box-shadow: 3px 4px 6px rgba(255, 127, 80, 0.8);
  }

  .card-text {
    text-align: justify;
  }

  .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }

  .active>.page-link,
  .page-link.active {
    background-color: coral !important;
    border: coral !important;
  }

  .save-button {
    font-size: 25px;
    color: coral;
    border: none;
    background-color: transparent;
  }

  .saved-icon {
    font-size: 25px;
    color: red;
    border: none;
    background-color: transparent;
  }

  .custom-tooltip {
    --bs-tooltip-bg: red;
  }

  /*css for average star raing*/

  .rating {
    unicode-bidi: bidi-override;
    direction: rtl;
    display: block;
    width: 100%;
    text-align: left;
  }

  .star1 {
    display: inline-block;
    font-size: 21px;
    /*color of unchecked star*/
    color: #ccc;
  }

  .star1.checked,
  .star1.checked~.star1 {
    color: coral;
  }



  .tags {
    padding: 2px 8px;
    margin: 0 5px 5px 0;
    border: none;
    border-radius: 8px;
    background-color: #f1f1f1;
  }

  .tags:hover {
    background-color: black;
    color: white;
  }
</style>
@endsection
<!-- this should be at the end of code -->