<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <title></title>
</head>
<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a class="navbar-brand" href="{{route('welcome')}}">Url Shortener</a>
    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{route('links.index')}}">List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('links.create')}}">create</a>
        </li>
    </ul>

</nav>
<div class="container-fluid bg-warning mw-100 mh-100 p-3 ">

    <div class="row">
@yield('content')
    </div>

</div>
<footer class="bg-dark text-light">
    <div class="container-fluid">
        <p class="m-auto text-center "> design by mojtaba</p>
    </div>
</footer>
<script src="/public/js/bootstrap.min.js"></script>
<script>
    function copy(linkid){
        var copyText = document.getElementById("copyInput"+linkid);
        copyText.select();
        document.execCommand("copy")
    }
</script>
</body>
</html>
