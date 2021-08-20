@extends('layout.master')


@section('content')


    <form action="{{route('user.store')}}" method="post" class="col-md-4 m-auto">
        @csrf
        <div class="alert alert-secondary text-center">
            welcome to your website
        </div>
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Enter your email">
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Enter your password">
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="confirm password">
        </div>
        <div class="input-group mb-3">
            <input type="submit" class="form-control btn btn-dark" value="submit">
        </div>
        @include('layout.errors')
    </form>



@endsection
