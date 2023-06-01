@extends ('layouts.main')
@section('content')

<main class="container">
    <section>
        <div class="d-flex align-items-center justify-content-between mb-3"> <!--align items at same row-->
            <h3> {{$message}} </h3>
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
                title: '{{ $message}}'
            });
        </script>
        @endif
        <div class="row">

            @foreach($recipes as $recipe)
            <div class="col-md-3"><!--display screen size-->
                <div class="card mb-3">
                    <img class="card-img-top" style="width: 100% ; height: 45%; object-fit: content;" src="{{asset('images/'. $recipe->image)}}" alt="Card image cap">{{--object-fit property to ensure that the image fills the available space while maintaining its aspect ratio.--}}
                    <div class="card-body">
                        <h4 class="card-title receip-title">{{ $recipe->title }}</h4>
                        <p class="card-text">{{$recipe->description }}</p>

                        <a href="{{ route('recipes.details', $recipe->id) }}" class="button start-1 bottom-0 mb-3">View Details</a>
                        @auth
                        @if(auth()->user()->id == $recipe->user_id)
                        <a href="{{ route('recipes.edit', $recipe->id) }}" style=" text-decoration: none; position: absolute; bottom: 10px;  right: 10px;"> <i class="ph-bold ph-pencil"></i></a>
                        <form method="post" action="{{ route('recipes.destroy', $recipe->id) }}" id="deleterecipe">
                            @method('delete')
                            @csrf
                            <button type="submit" onclick="deleteConfirm(event)" class="btn" style=" color: red; position: absolute; bottom: 4px;  right: 30px;"> <i class="ph-bold ph-trash"></i> </button>
                        </form>
                        @endif


                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        </div>
    </section>
</main>
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
</style>

@endsection