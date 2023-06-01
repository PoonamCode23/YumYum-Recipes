@extends('layouts.main')
@section('content')

<!-- ##### Top Catagory Area Start ##### -->
{{--<section class="top-catagory-area section-padding-80-0">
        <div class="container">
            <div class="row">
                <!-- Top Catagory Area -->
                <div class="col-12 col-lg-6">
                    <div class="single-top-catagory">
                        <img src="{{asset('logo.png')}}" alt="">
<!-- Content -->
<div class="top-cta-content">
  <h3>Strawberry Cake</h3>
  <h6>Simple &amp; Delicios</h6>
  <a href="receipe-post.html" class="btn delicious-btn">See Full Receipe</a>
</div>
</div>
</div>
<!-- Top Catagory Area -->
<div class="col-12 col-lg-6">
  <div class="single-top-catagory">
    <img src="{{asset('logo.png')}}" alt="">
    <!-- Content -->
    <div class="top-cta-content">
      <h3>Chinesse Noodles</h3>
      <h6>Simple &amp; Delicios</h6>
      <a href="receipe-post.html" class="btn delicious-btn">See Full Receipe</a>
    </div>
  </div>
</div>
</div>
</div>
</section>--}}
<!-- ##### Top Catagory Area End ##### -->
<main class="container">
  <div class="row">
    @foreach($recipes as $recipe)
    <div class="col-md-3"><!-- Display screen size -->
      <div class="card mb-3">
        <img class="card-img-top" style="width: 100%; height: 45%; object-fit: content;" src="{{ asset('images/' . $recipe->image) }}" alt="Card image cap"><!-- Object-fit property to ensure that the image fills the available space while maintaining its aspect ratio -->
        <div class="card-body">
          <h4 class="card-title receip-title mb-3">{{ $recipe->title }}</h4>
          <p class="card-text">{{ $recipe->description }}</p>


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
  </div>
</main>

@endsection





<style>
  .button {
    color: black;
    background-color: coral;
    position: absolute;
    text-decoration: none;
    padding: 5px;
    transition: box-shadow 0.4s ease;
  }

  .button:hover {
    box-shadow: 3px 4px 6px rgba(255, 127, 80, 0.8);
  }

  .card {
    transition: box-shadow 0.4s ease;
  }

  .card:hover {
    box-shadow: 3px 4px 6px rgba(255, 127, 80, 0.5);
  }



  .card-text {
    text-align: justify;
  }


















  /* Custom styles for the top category section */
  .top-catagory-area {
    padding: 80px 0;
  }

  .single-top-catagory {
    position: relative;
    margin-bottom: 30px;
  }

  .single-top-catagory img {
    width: 100%;
    height: auto;
    border-radius: 4px;
    opacity: 0.5;
  }

  .top-cta-content {
    position: absolute;
    bottom: 20px;
    left: 20px;
    color: #fff;
  }

  .top-cta-content h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 10px;
  }

  .top-cta-content h6 {
    font-size: 14px;
    font-weight: 400;
    margin-bottom: 20px;
  }

  .top-cta-content a {
    display: inline-block;
    padding: 12px 25px;
    background-color: #ff4b2b;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    text-decoration: none;
    border-radius: 4px;
  }

  .top-cta-content a:hover {
    background-color: #e6331a;
  }

  @media (max-width: 767px) {
    .top-cta-content {
      position: static;
      text-align: center;
    }

    .top-cta-content h3 {
      font-size: 20px;
    }
  }
</style>