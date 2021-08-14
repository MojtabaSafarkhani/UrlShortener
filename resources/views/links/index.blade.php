@extends('layout.master')


@section('content')




        <div class="col-md-10 m-auto">

                <div class="alert alert-danger  text-center h2">
                    List of Links
                </div>


            <table class="table table-bordered table-striped table-hover table-responsive text-center table-dark">
                <thead>
                <tr>
                    <td>#</td>
                    <td>Original Url</td>
                    <td>Short Url</td>
                    <td>Copy</td>
                    <td>Delete</td>
                </tr>
                </thead>
                <tbody>
                @foreach($links as $key=> $link)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$link->Url}}</td>
                    <td>
                        <a href="/{{$link->UrlShortener}}">http://127.0.0.1:8000/{{$link->UrlShortener}}</a>

                    </td>
                    <td>
                        <input id="copyInput{{$link->id}}" class="mb-1"  type="text" value="http://127.0.0.1:8000/{{$link->UrlShortener}}">
                        <button class="btn btn-success" type="button" onclick="copy({{$link->id}});">Copy</button> </td>
                    <td>
                        <form action="{{route('links.destroy',$link)}}" method="post">
                            @csrf
                            @method("DELETE")
                            <input type="submit" value="DELETE" class="btn btn-danger ">
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>



@endsection
