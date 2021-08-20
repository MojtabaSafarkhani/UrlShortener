@extends('layout.master')

@section('content')
    @if(session()->has('success'))
        <div class="alert alert-success col-md-8 text-center m-auto" style="height:50px">
            {{session()->get('success')}}
        </div>
    @endif


    <div class=" col-md-8 m-auto">

        <p class="h1 text-center"> Welcome To Url Shortener </p>
        <p class="h3 text-center"> Best Way To Short your Urls :) </p>

    </div>



@endsection
