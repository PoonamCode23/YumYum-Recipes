@extends('layouts.main')
@section('content')
<main class="container" style="margin-top:124px;">
  <div class="row">
    @if (!empty($tag) || !empty($category))
    <div class="category-message">
      {{$message}}
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
            <form method="GET" action="{{ route('welcome') }}"><!--use this form inside for each loop or else data will be submitted as many as tags are available.-->
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
          <form method="post" action="{{ route('recipes.destroy', $recipe->id) }}">
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
    <div class="pagination">
      {{ $recipes->links() }} <!--see app\provider\appserviceprovider-->
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
  window.deleteConfirm = function(e) {
    e.preventDefault();
    var form = document.getElementById('deleterecipe');
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


  .star1.half {
    position: relative;
    overflow: hidden;
  }

  .star1.half:before {
    content: '\2605';
    position: absolute;
    top: 0;
    left: 0;
    width: 50%;
    overflow: hidden;
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