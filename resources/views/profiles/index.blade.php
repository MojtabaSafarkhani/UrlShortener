@extends('layout.master')


@section('content')




    <div class="col-md-10 m-auto">

        <div class="alert alert-secondary text-center h2">
            profile {{$user->email}}
        </div>


        <div class="table-responsive-md">
            <table class="table table-bordered table-striped table-hover  align-middle text-center table-dark">
                <thead>
                <tr>
                    <td>name</td>
                    <td>email</td>
                    <td>verify email</td>
                    <td>edit</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        @if($user->name!=null)
                            {{$user->name}}
                        @else
                            NULL
                        @endif
                    </td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->email_verified_at->format('y-m-d H:i:s')}}</td>
                    <td>
                        <a href="{{route('profile.edit',auth()->user())}}" class="btn btn-primary">edit</a>
                    </td>

                </tr>

                </tbody>
            </table>
        </div>
    </div>



@endsection
