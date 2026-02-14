<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
<main class="form-signin w-100 m-auto container" style="max-width: 330px;">
    
    <form action="{{ route('login') }}" method="POST">
        @csrf <h1 class="h3 mb-3 fw-normal">Silakan Login</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-floating mb-2">
            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
            <label for="email">Email address</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        
        <hr>
        <a href="{{ route('google.login') }}" class="w-100 btn btn-outline-danger">
            Login with Google
        </a>

        <p class="mt-3 text-center">Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a></p>
    </form>
</main>
</body>
</html>