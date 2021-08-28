@extends('layout.master')


@section('content')


    <form action="{{route('profile.update')}}" method="post" class="col-md-4 m-auto">
        @csrf
        @method("PATCH")
        <div class="alert alert-secondary text-center">
            edit your information
        </div>
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" value="{{$user->name}}"
                   placeholder="Enter your name">
        </div>
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" value="{{$user->email}}"
                   placeholder="Enter your email">
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control"
                   placeholder="Enter your password">
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control"
                   placeholder="confirm password">
        </div>
        <div class="input-group mb-3">
            <input type="submit" class="form-control btn btn-dark" value="update">
        </div>
        @include('layout.errors')
    </form>



@endsection
