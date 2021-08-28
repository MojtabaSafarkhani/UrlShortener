@extends('layout.master')

@section('content')



    <div class=" col-md-8 m-auto">
        <div class="alert alert-secondary text-center">
            {{auth()->user()->email}}
        </div>
        <p class="h1 text-center">Check Your Email For Verify! </p>
        @if(!auth()->user()->hasVerifiedEmail())
            <p class="h3 text-center">if you don't have any email please Click on Resend and check your email</p>
            <form class="text-center mt-2" method="post" action="{{route('verification.send')}}">
                @csrf
                <input type="submit" class="btn btn-primary " value="Resend">
            </form>
        @endif
        @include('layout.errors')

    </div>



@endsection
