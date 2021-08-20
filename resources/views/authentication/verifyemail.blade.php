@extends('layout.master')

@section('content')
    @if(session()->has('verify email'))
        <div class="alert alert-danger col-md-8 text-center m-auto" style="height:50px">
            {{session()->get('verify email')}}
        </div>
    @endif

    <form action="{{route('user.verifyemail.store')}}" method="post" class="col-md-4 m-auto">
        @csrf
        <div class="alert alert-secondary text-center">
             Check your email
            <p>{{auth()->user()->email}}</p>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="code" class="form-control" placeholder="Verify Email">
        </div>
        <div class="input-group mb-3">
            <input type="submit" class="form-control btn btn-dark" value="submit">
        </div>
        @include('layout.errors')
    </form>

@endsection
