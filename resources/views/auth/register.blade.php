<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
<main class="form-signin w-100 m-auto container" style="max-width: 330px;">
    
    <form action="{{ route('register') }}" method="POST">
        @csrf
        
        <h1 class="h3 mb-3 fw-normal">Daftar Akun</h1>

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
            <input type="text" name="name" class="form-control" id="name" placeholder="Nama Lengkap" required value="{{ old('name') }}">
            <label for="name">Nama Lengkap</label>
        </div>

        <div class="form-floating mb-2">
            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
            <label for="email">Email address</label>
        </div>

        <div class="form-floating mb-2">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            <label for="password">Password (Min 6 karakter)</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi Password" required>
            <label for="password_confirmation">Ulangi Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Daftar</button>
        <p class="mt-3 text-center">Sudah punya akun? <a href="{{ route('login') }}">Login disini</a></p>
    </form>
</main>
</body>
</html>