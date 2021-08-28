@extends('layout.master')


@section('content')


    <form action="{{route('login.store')}}" method="post" class="col-md-4 m-auto">
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
        <div class="form-check form-switch">
            <label for="left-side">remember me</label>
            <input class="form-check-input" name="remember_me" id="left-side" type="checkbox">
        </div>

        <div class="input-group mb-3">
            <input type="submit" class="form-control btn btn-dark" value="submit">
        </div>
        <div class="input-group mb-3">
            <a href="{{route('forget.create')}}" class="form-control btn btn-secondary btn-sm ">
                forget your password ?
            </a>
        </div>
        @include('layout.errors')
    </form>



@endsection
