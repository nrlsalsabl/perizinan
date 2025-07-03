<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perizinan Online - Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
        }
        
        body {
            background: linear-gradient(135deg, #1e5799 0%, #207cca 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            overflow-x: hidden;
            transition: all 0.3s ease;
        }
        
        .login-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }
        
        h2 {
            color: var(--dark-color);
            font-weight: 700;
            position: relative;
            padding-bottom: 10px;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn {
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            text-transform: uppercase;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2980b9 100%);
            border: none;
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #27ae60 100%);
            border: none;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .forgot-password-link {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .forgot-password-link:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        
        .form-check-label {
            color: #7f8c8d;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center mb-4"><i class="fas fa-user-lock mr-2"></i>Login Perizinan Online</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email" class="font-weight-bold">Email</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="font-weight-bold">Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password Anda" required>
                </div>
                <div class="form-check mt-2">
                    <input type="checkbox" class="form-check-input" id="show_password">
                    <label class="form-check-label" for="show_password">Tampilkan Password</label>
                </div>
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-success btn-block"
                    onclick="window.location='{{ route('registrasi.index') }}'">
                    <i class="fas fa-user-plus mr-2"></i>Register
                </button>
            </div>
            <div class="form-group text-center mt-3">
                <a href="{{ route('password.request') }}" class="forgot-password-link">
                    <i class="fas fa-question-circle mr-1"></i>Lupa Password?
                </a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('show_password').addEventListener('change', function() {
            var passwordField = document.getElementById('password');
            if (this.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
