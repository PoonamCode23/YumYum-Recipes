<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center mb-5 bg-body rounded">
    <nav class="navbar navbar-expand-lg bg-body-tertiary nav-underline mb-5" id="pills-tab" role="tablist" style="box-shadow: 0 10px 25px -18px coral;">
        <div class="container d-flex">
            <a href="{{ route('welcome') }}">
                <img src="{{ asset('logo.png') }}" alt="logo" style="width:220px;height: auto;margin-right: 20px;">
            </a>
            <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">

                <!-- justify-content-between provides gap between two items. -->
                <form method="GET" action="{{ route('recipes.index') }}" class="d-flex mb-0" role="search">
                    @csrf
                    <div class="input-group me-5">
                        <input class="form-control" type="text" placeholder="Search Recipe" name="search" value="{{ request('search') }}" aria-label="Search">
                        <button class="btnn" type="submit">
                            <i class="ph-bold ph-magnifying-glass fs-4"></i>
                        </button>
                    </div>
                </form>
                <div>
                    <ul class="navbar-nav">
                        @if (Route::has('login'))
                        @auth
                        <li class="nav-item me-3">
                            <a class="nav-link fs-5" aria-current="page" href="{{ route('recipes.index') }}">My Recipes </a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link fs-5" aria-current="page" href="{{ route('recipes.saved')}}">Saved Recipes ({{$savedRecipesCount}})</a> <!-- see AppServiceProvider. php where this count is used globally-->
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link fs-5" aria-current="page" href="{{ route('recipes.create') }}">Add Recipe</a>
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
                            <a class="nav-link  fs-5" aria-current="page" href="{{ route('login') }}">Log In</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item me-3">
                            <a class="nav-link fs-5" aria-current="page" href="{{ route('register') }}">Register</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link fs-5" aria-current="page" href="{{ route('recipes.create') }}">Add Recipe</a>
                        </li>
                        @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
<style>
    .btnn {
        background-color: white;
        color: coral;
        border: 2px white;
    }

    .navbar {
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1;
    }

    .nav-underline .nav-link:focus,
    .nav-underline .nav-link:hover {
        border-bottom-color: coral;
    }
</style>