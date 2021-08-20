@extends('layout.master')


@section('content')


    <form action="{{route('profile.update',auth()->user())}}" method="post" class="col-md-4 m-auto">
        @csrf
        @method("PATCH")
        <div class="alert alert-secondary text-center">
            edit your information {{$user->email}}
        </div>
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" value="{{$user->name}}" placeholder="Enter your name">
        </div>
        <div class="input-group mb-3">

            <input type="password" name="password"
                   class="form-control"
                   placeholder="Enter your password">
        </div>
        <div class="input-group mb-3">
            <input type="password" value="" name="password_confirmation" class="form-control" placeholder="confirm password">
        </div>
        <div class="input-group mb-3">
            <input type="submit" class="form-control btn btn-dark" value="submit">
        </div>
        @include('layout.errors')
    </form>



@endsection
