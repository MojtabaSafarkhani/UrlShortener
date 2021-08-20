@if($errors)
    <ul  class="bg-danger">
        @foreach($errors->all() as $error)

               <li>
                   {{$error}}
               </li>

        @endforeach
    </ul>


@endif
