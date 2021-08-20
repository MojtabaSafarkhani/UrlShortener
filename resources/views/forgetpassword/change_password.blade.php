@extends('layout.master')


@section('content')


    <form action="{{route('login.with.forget.password',$user)}}" method="post" class="col-md-4 m-auto">
        @csrf

        <div class="alert alert-secondary text-center">
            welcome to your website<br>
            your email: {{$user->email}}
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="enter password">
        </div>
        <div class="input-group mb-3">
            <input type="submit" class="form-control btn btn-dark" value="submit">
        </div>

        @include('layout.errors')
    </form>



@endsection
