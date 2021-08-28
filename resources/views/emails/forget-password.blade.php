<!DOCTYPE html>
<html lang="en">

<head>
    <title>forget password</title>
</head>
<body>
<h1>Forget Password Email</h1>
You can reset password from bellow link:
<a href="{{ route('reset.password.create', $token) }}" class="btn btn-dark">Reset Password</a>
</body>
</html>

