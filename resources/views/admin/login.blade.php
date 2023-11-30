<!-- resources/views/admin/login.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Toy Store</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan link untuk ikon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-AVr5KuuWOBHgBF3Mz5PLD1djPAEeDCiQHLe6CPLvvZcvAyjLMIv2O81BqBqIfWTNGkoq7Bu6HOS/N9lD4OC4jg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tambahkan link untuk favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <style>
        /* Tambahkan gaya CSS khusus di sini */
        .brand-text {
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .card-header {
            display: none; /* Sembunyikan judul Login */
        }
    </style>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <!-- Tambahkan teks besar dan ikon di sini -->
                    <div class="brand-text">
                        Toy Store Kelompok 20
                    </div>

                    <div class="card-header">Login Toy Store</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('auth') }}">
                            @csrf

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username" type="text" class="form-control" name="username">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password">
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </form>
                        @if($errors->any())
                        <div class="alert alert-danger mt-3" role="alert" id="error-message">
                            {{ $errors->first() }}
                            <script>
                                setTimeout(function () {
                                    document.getElementById('error-message').style.display = 'none';
                                }, 2000); // Setelah 2 detik, sembunyikan pesan
                            </script>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>