@extends ('layouts.main')
@section('content')
<div class="container mb-5">

    <img src="{{ asset('images/'.$recipe->image) }}" alt="Recipe Image" class="image-banner">
</div>

<div class="receipe-content-area">
    <div class="container mt-3">
        <h4 style="text-align:justify;"> {{$recipe->description}}</h4>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="receipe-headline my-5">
                    <span> {{ date('F j, Y', strtotime($recipe->created_at)) }}</span>
                    <h2>{{ $recipe->title }}</h2>
                    <div class="receipe-duration ">
                        <h5> Preparation Time: {{ $recipe->time_required }}</h5>
                        <h5>Servings:{{$recipe->servings}}</h5>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-8">
                    <h2>Steps</h2>
                    <div class="step d-flex">
                        <ol>
                            @foreach ($directions as $direction)
                            <li>
                                <p>{{ old('$direction', $direction ?? '')}}</p>
                            </li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                <!-- Ingredients -->
                <div class="col-12 col-lg-4">
                    <div class="ingredients">
                        <h3>Ingredients</h3>

                        @foreach ($ingredients as $ingredient)
                        <div class="custom-checkbox d-flex"> <!--d-flex aligns items in the straight lines-->
                            <input class="form-check-input " type="checkbox" value="" id="flexCheckChecked">
                            <label class="label" for="customCheck1">{{ $ingredient }}</label>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if (isset($existingReview))
            <div class="container mt-3 mb-3">

                <ul class="list-group">

                    <div class="col-12 col-lg-8">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-9">
                                    <h3>My Review</h3>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="editicon" onclick="showForm('ratingForm')"><i class="ph-fill ph-pencil"></i>Edit</button>
                                </div>

                                <div class=" row mt-3">
                                    <div class="col-6">
                                        <div class="rating mb-3">
                                            <input type="hidden" name="rating" id="rating">
                                            <label for="star5" class="star1 {{ $existingReview->ratings == 5 ? 'checked' : '' }}" data-rating="5"><i class="ph-fill ph-star"></i></label>
                                            <label for="star4" class="star1 {{ $existingReview->ratings == 4 ? 'checked' : '' }}" data-rating="4"><i class="ph-fill ph-star"></i></label>
                                            <label for="star3" class="star1 {{ $existingReview->ratings == 3 ? 'checked' : '' }}" data-rating="3"><i class="ph-fill ph-star"></i></label>
                                            <label for="star2" class="star1 {{ $existingReview->ratings == 2 ? 'checked' : '' }}" data-rating="2"><i class="ph-fill ph-star"></i></label>
                                            <label for="star1" class="star1 {{ $existingReview->ratings == 1 ? 'checked' : '' }}" data-rating="1"><i class="ph-fill ph-star"></i></label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <p>{{date('F j, Y', strtotime($existingReview->created_at)) }}</p> <!--use comment table date not recipe table-->
                                    </div>
                                    <p class="fs-4">{{ $existingReview->comments }}</p>

                                    <form action="{{ route('comments.like', ['commentId' => $existingReview->id]) }}#comment-{{ $existingReview->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="like-button">
                                            <i class="ph-fill ph-thumbs-up thumbs-up-icon"></i>
                                        </button>
                                        <span class="likes-count"> ({{ $existingReview->likes->count() }})</span>
                                    </form>
                                </div>
                        </li>
                    </div>
                </ul>
            </div>
            <div id="updateRating" style="display: none;">
                <form action="{{route('reviews.updateReviews', $existingReview->id)}}" method="POST" id="updateRatingForm"><!--choose the exact id that u wanna review-->
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
                    <div class="container mt-3">
                        <div class="card p-5">
                            <div class="row align-items-center">
                                <div class="col-2 mb-3">
                                    <img src="{{ asset('images/'.$recipe->image) }}" class="rounded-circle mt-2 w-75 h-75">
                                </div>
                                <div class="  col-10">
                                    <h3>{{ $recipe->title }}</h3>
                                </div>
                                <div class="comment-box ml-2">
                                    <h4>Your Rating</h4>
                                    <div class="rating mb-3">
                                        <input type="hidden" name="rating" id="rating-edit">
                                        <label for="star5" class="star star-edit" data-rating-edit="5" value='5'><i class="ph-fill ph-star"></i></label>
                                        <label for="star4" class="star star-edit" data-rating-edit="4" value='4'><i class="ph-fill ph-star"></i></label>
                                        <label for="star3" class="star star-edit" data-rating-edit="3" value='3'><i class="ph-fill ph-star"></i></label>
                                        <label for="star2" class="star star-edit" data-rating-edit="2" value='2'><i class="ph-fill ph-star"></i></label>
                                        <label for="star1" class="star star-edit" data-rating-edit="1" value='1'><i class="ph-fill ph-star"></i></label>
                                    </div>
                                    <h4>Your Review</h4>
                                    <div class="comment-area mb-4">
                                        <textarea class="form-control" name="review" placeholder="What is your view?" rows="4">{{ $existingReview->comments }}</textarea>
                                    </div>
                                    <div class="comment-btns mt-2">
                                        <div class="d-flex align-items-center justify-content-end">

                                            <div class="pull-left me-3">
                                                <button type="button" class="button btn-success btn-sm" onclick="resetRatingForm(this)">Cancel</button>
                                            </div>

                                            <div class="pull-right">
                                                <button type="submit" value="submit" class="button btn-success send btn-sm">Submit <i class="fa fa-long-arrow-right ml-1"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @else
        <h2>Reviews</h2>

        <form action="{{route('recipes.store-ratings')}}" method="POST" id="ratingForm">
            @csrf
            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
            <div class="container mt-3">
                <div class="card p-5">
                    <div class="row align-items-center">
                        <div class="col-2 mb-3">
                            <img src="{{ asset('images/'.$recipe->image) }}" class="rounded-circle mt-2 w-75 h-75">
                        </div>
                        <div class="  col-10">
                            <h3>{{ $recipe->title }}</h3>
                        </div>
                        <div class="comment-box ml-2">
                            <h4>Your Rating</h4>
                            <div class="rating mb-3">
                                <input type="hidden" name="rating" id="rating">
                                <label for="star5" class="star" data-rating="5" value='5'><i class="ph-fill ph-star"></i></label>
                                <label for="star4" class="star" data-rating="4" value='4'><i class="ph-fill ph-star"></i></label>
                                <label for="star3" class="star" data-rating="3" value='3'><i class="ph-fill ph-star"></i></label>
                                <label for="star2" class="star" data-rating="2" value='2'><i class="ph-fill ph-star"></i></label>
                                <label for="star1" class="star" data-rating="1" value='1'><i class="ph-fill ph-star"></i></label>
                            </div>
                            <h4>Your Review</h4>
                            <div class="comment-area mb-4">
                                <textarea class="form-control" name="review" placeholder="What is your view?" rows="4"></textarea>
                            </div>
                            <div class="comment-btns mt-2">
                                <div class="d-flex align-items-center justify-content-end">

                                    <div class="pull-left me-3">
                                        <button type="button" class="button btn-success btn-sm" onclick="resetRatingForm('ratingForm')">Cancel</button>
                                    </div>


                                    <div class="pull-right">
                                        <button type="submit" class="button btn-success send btn-sm">Submit <i class="fa fa-long-arrow-right ml-1"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>

    @if(!empty($comments) && count($comments) > 0)
    <div class="container mt-3 mb-3">
        <h3>Other Helpful Reviews</h3>
        <ul class="list-group">
            <div class="col-12 col-lg-8">
                @foreach($comments as $comment)
                <li class="list-group-item" id="comment-{{ $comment->id }}"> <!--anchor-->
                    <p class="text"> Reviewed by: <a href="{{ route('recipes.user', $comment->user_id) }}" class="link"> {{$comment->user->name;}}</a></p> <!--use $comments instead of $recipe in href link-->
                    <div class="row">
                        <div class="col-6">
                            <div class="rating mb-3">
                                <input type="hidden" name="rating" id="rating">
                                <label for="star5" class="star1 {{$comment->ratings==5 ? 'checked' : ''}}" data-rating="5"><i class="ph-fill ph-star"></i></label>
                                <label for="star4" class="star1 {{$comment->ratings==4 ? 'checked' : ''}} " data-rating="4"><i class="ph-fill ph-star"></i></label>
                                <label for="star3" class="star1 {{$comment->ratings==3 ? 'checked' : ''}} " data-rating="3"><i class="ph-fill ph-star"></i></label>
                                <label for="star2" class="star1 {{$comment->ratings==2 ? 'checked' : ''}} " data-rating="2"><i class="ph-fill ph-star"></i></label>
                                <label for="star1" class="star1 {{$comment->ratings==1 ? 'checked' : ''}} " data-rating="1"><i class="ph-fill ph-star"></i></label>
                            </div>
                        </div>
                        <div class="col-6">
                            <p>{{date('F j, Y', strtotime($comment->created_at)) }}</p> <!--use comment table date not recipe table-->
                        </div>
                        <p class="fs-4">{{ $comment->comments }}</p>
                    </div>
                    <form action="{{ route('comments.like', ['commentId' => $comment->id]) }}#comment-{{ $comment->id }}" method="POST"><!--anchor-->
                        @csrf
                        <button type="submit" class="like-button">
                            <i class="ph-fill ph-thumbs-up thumbs-up-icon"></i>
                        </button>
                        <span class="likes-count"> ({{ $comment->likes->count() }})</span>
                    </form>
                </li>
                @endforeach
        </ul>
    </div>
    @elseif(count($comments) == 0 && !$existingReview)
    <p>Be the first reviewer of this recipe.</p>
    @endif
</div>



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
        title: '{{ $message }}'
    });
</script>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script type="text/javascript">
    $(document).ready(function() {
        $('.star').click(function() {
            var rating = $(this).data('rating');
            console.log($(this));
            $('#rating').val(rating);
            $('.star').removeClass('checked');
            $(this).addClass('checked');
        });

        $('.star-edit').click(function() {
            var rating_edit = $(this).data('rating-edit');
            $('#rating-edit').val(rating_edit);
            $('.star').removeClass('checked');
            $(this).addClass('checked');
        });
    });

    function resetRatingForm(formName) {
        formName.form.reset();
    }



    function showForm() {
        var form = document.getElementById('updateRating');
        form.style.display = "block";
    }
</script>




<style>
    .image-banner {
        width: 100%;
        height: 65%;
        object-fit: cover;
        margin-bottom: 30px;

    }

    .button {
        background-color: coral;
        border: none;
        border-radius: 7px;
        padding: 5px;
    }

    .editicon {
        color: coral;
        border: none;
        background-color: transparent;

    }

    .text {
        font-size: 20px;
        margin-bottom: 15px;
    }

    .link {
        color: black;
    }

    a:hover {
        color: coral;
    }

    .receipe-duration {
        border-left: 3px solid #40ba37;
        padding: 15px;
    }

    .form-check-input {
        width: 25px !important;
        height: 25px !important;
        border: 1px solid black !important;
        margin-right: 10px;
    }

    .step {
        font-size: 23px;
    }

    .label {
        font-size: 20px;
    }

    .custom-checkbox .form-check-input:checked+.label {
        color: green;
    }

    .rating {
        unicode-bidi: bidi-override;
        direction: rtl;
        display: block;
        width: 100%;
        text-align: left;
    }


    .star {
        display: inline-block;
        font-size: 40px;
        color: #ccc;
        cursor: pointer;
    }

    .star1 {
        display: inline-block;
        font-size: 40px;
        color: #ccc;
    }

    .star:hover,
    .star:hover~.star {
        color: coral;
    }


    .star.checked,
    .star.checked~.star {
        color: coral;
    }

    .star1.checked,
    .star1.checked~.star1 {
        color: coral;
    }

    .star2 {
        display: inline-block;
        font-size: 40px;
        color: #ccc;
        cursor: pointer;
    }

    .star2:hover,
    .star2:hover~.star2 {
        color: coral;
    }

    .star2.checked,
    .star2.checked~.star2 {
        color: coral;
    }

    .form-check-input:checked {
        background-color: green !important;
        outline: none;
        box-shadow: none;
    }

    .form-check-input:focus {
        box-shadow: none !important;
    }

    .thumbs-up-icon {
        color: grey;
        font-size: 30px;
    }

    .like-button {
        border: none;
        background-color: transparent;

    }

    .like-button:hover,
    .like-button:hover~.like-button {
        color: coral;
    }


    .like-button.checked,
    .like-button.checked~.like-button {
        color: coral;
    }
</style>

@endsection