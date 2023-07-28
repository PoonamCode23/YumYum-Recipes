<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center mb-5 bg-body rounded">
    <div class="bg-body-tertiary" style="box-shadow: 0 10px 25px -18px coral; position: fixed;width: 100%;top: 0;z-index: 1;">
        <nav class="navbar navbar-expand-lg bg-body-tertiary nav-underline mb-1" id="pills-tab" role="tablist">
            <div class="container d-flex">
                <a href="{{ route('homepage') }}">
                    <img src="{{ asset('logo.png') }}" alt="logo" style="width:220px;height: auto;margin-right: 20px;">
                </a>
                <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">

                    <!-- justify-content-between provides gap between two items. -->

                    <div>
                        <ul class="navbar-nav">
                            @if (Route::has('login'))
                            @auth
                            <li class="nav-item me-3">
                                <a class="nav-link fs-5" aria-current="page" href="{{ route('homepage') }}">Home </a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link fs-5" aria-current="page" href="{{ route('recipes.index') }}">My Recipes </a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link fs-5" aria-current="page" href="{{ route('recipes.saved')}}">Saved Recipes ({{$savedRecipesCount}})</a> <!-- see AppServiceProvider. php where this count is used globally-->
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link fs-5" aria-current="page" href="{{ route('recipes.createrecipes') }}">Add Recipe</a>
                            </li>
                            <li class="nav-item me-3">
                                <div class="dropdown">
                                    <button class="btn bg-none border-none dropdown-toggle fs-5" type="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ph-bold ph-user"></i>
                                        {{ Auth::user() ? Auth::user()->name : '' }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{route('profile.edit')}}">My Profile</a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                @method('POST')
                                                <button class="btn bg-none border-none fs-6" href="{{ route('logout') }}">Log Out</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @else
                            <li class="nav-item me-3">
                                <a class="nav-link fs-5" aria-current="page" href="{{ route('homepage') }}">Home </a>
                            </li>
                            <li class="nav-item me-3">
                                <a class="nav-link  fs-5" aria-current="page" href="{{ route('login') }}">Log In</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item me-3">
                                <a class="nav-link fs-5" aria-current="page" href="{{ route('register') }}">Register</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link fs-5" aria-current="page" href="{{ route('recipes.createrecipes') }}">Add Recipe</a>
                            </li>
                            @endauth
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container ">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex">
                    <div class="dropdown">
                        <button class="btn bg-none border-none dropdown-toggle" type="button" id="recipeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Recipes
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="recipeDropdown">
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'breakfast']) }}">Breakfast</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'lunch']) }}">Lunch</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'dinner']) }}">Dinner</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'salad']) }}">Salads</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'soups']) }}">Soups</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'desserts']) }}">Desserts</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'bakery']) }}">Bakery</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'drinks']) }}">Drinks</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'vegan']) }}">Vegan</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'non-veg']) }}">Non-Veg</a></li>
                        </ul>

                    </div>
                    <div class="dropdown">
                        <button class="btn bg-none border-none dropdown-toggle" type="button" id="ingredientDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Ingredients
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="ingredientDropdown">
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'chicken']) }}">Chicken</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'seafood']) }}">Seafood</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'flour']) }}">Flour</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'fruits']) }}">Fruits</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'vegetables']) }}">Vegetables</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn bg-none border-none dropdown-toggle" type="button" id="occasionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Occasions </button>
                        <ul class="dropdown-menu" aria-labelledby="occasionDropdown">
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'summer']) }}">Summer Recipes</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'winter']) }}">Winter Recipes</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'festival']) }}">Festivals</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'birthday']) }}">Birthday</a></li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn bg-none border-none dropdown-toggle" type="button" id="cuisineDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Cuisines
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="cuisineDropdown">
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'nepali']) }}">Nepali</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'italian']) }}">Italian</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'indian']) }}">Indian</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'japanese']) }}">Japanese</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'chinese']) }}">Chinese</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'korean']) }}">Korean</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'filipino']) }}">Filipino</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.category', ['category' => 'mexican']) }}">Mexican</a></li>
                        </ul>
                    </div>
                </div>
                <form method="GET" action="{{ route('recipes.index') }}" class="d-flex mb-0" role="search">
                    @csrf
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Search Recipe" name="search" value="{{ request('search') }}" aria-label="Search">
                        <button class="btnn" type="submit">
                            <i class="ph-bold ph-magnifying-glass fs-4"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</div>

</div>

<style>
    .btnn {
        background-color: white;
        color: coral;
        border: 2px white;
    }

    /* .navbar {
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1;
    } */

    .nav-underline .nav-link:active,
    .nav-underline .nav-link:hover {
        border-bottom-color: coral;
        color: coral;
    }

    .dropdown-toggle {
        font-size: 18px;
        border-color: transparent !important;
    }

    .dropdown-toggle:hover {
        color: coral;
        border-color: transparent !important;
        outline: none;
    }

    .dropdown-toggle:focus {
        color: coral;
    }

    .dropdown-item {
        padding: 10px;
    }

    .dropdown-item:hover {
        color: coral;
        background-color: wheat;
    }

    .navbar-nav .nav-link.active {
        color: coral;
    }
</style>