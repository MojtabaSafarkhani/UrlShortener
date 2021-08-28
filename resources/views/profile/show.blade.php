@extends('layout.master')


@section('content')




    <div class="col-md-10 m-auto">

        <div class="alert alert-danger text-center h2">
           Profile {{$user->email}}
        </div>


        <div class="table-responsive-md">
            <table class="table table-bordered table-striped table-hover  align-middle text-center table-dark">
                <thead>
                <tr style="width: 50%">

                    <td>Name</td>
                    <td>Email</td>
                    <td>Verify-At</td>
                    <td>Edit</td>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->email_verified_at}}</td>
                        <td><a href="{{route('profile.edit',$user)}}" class="btn btn-primary">edit</a></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>



@endsection
