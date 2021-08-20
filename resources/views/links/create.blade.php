@extends('layout.master')


@section('content')



    <div class="col-md-6 m-auto">
        <form action="{{route('links.store')}}" method="post">
            @csrf
            <div class="form-group mt-3">
                <input type="text" class="form-control mb-2" name="url" placeholder="Enter your link">
            </div>
            <div class="form-group">
                <input type="submit" class="form-control btn btn-dark btn-block" value="Submit">
            </div>
        </form>
        <br>
        @include('layout.errors')
    </div>



@endsection
