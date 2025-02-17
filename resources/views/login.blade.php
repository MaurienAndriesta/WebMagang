<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PLN Icon Plus</title>
    <style>
        /* General Reset */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #2A7296;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container */
        .login-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 450px; /* Perbesar lebar */
            padding: 20px; /* Tambahkan padding */
        }
        .banner img {
            width: 100%; /* Perbesar gambar */
            height: auto;
        }
        .banner h2 {
            color: #2A7296;
            margin-top: 20px;
            font-size: 20px; /* Ukuran font lebih besar */
        }

        /* Form */
        .login-form {
            padding: 20px; /* Perbesar padding form */
        }
        .form-group {
            margin-bottom: 20px; /* Tambahkan jarak antar elemen */
        }
        label {
            font-size: 16px; /* Ukuran label lebih besar */
            color: #333333;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px; /* Tambahkan padding input */
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px; /* Ukuran font input lebih besar */
            outline: none;
        }
        .password-wrapper {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555555;
            font-size: 16px; /* Ikon lebih besar */
        }
        .login-button {
            width: 100%;
            padding: 12px; /* Tambahkan padding tombol */
            background-color: #2A7296;
            color: #ffffff;
            font-size: 18px; /* Ukuran font tombol lebih besar */
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .login-button:hover {
            background-color: #2A7296;
        }
        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #2A7296;
            text-decoration: none;
            font-size: 14px; /* Ukuran font link lebih besar */
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="banner">
            <img src="img/loginicon.jpg" alt="PLN Icon Plus Banner">
        </div>
        <form action="{{ route('login') }}" method="POST" class="login-form">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
                <!-- Menampilkan error untuk username -->
        @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                    <!-- Menampilkan error untuk password -->
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
                    <span class="toggle-password">👁</span>
                </div>
            </div>
            <button type="submit" class="login-button">Login</button>
            <a href="#" class="forgot-password">Forgot password?</a>
        </form>
    </div>
    <script>
    // Script untuk toggle password visibility
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.querySelector('#password');

    togglePassword.addEventListener('click', () => {
        // Cek apakah password sedang terlihat
        const isPasswordVisible = passwordInput.getAttribute('type') === 'text';
        // Ubah tipe input
        passwordInput.setAttribute('type', isPasswordVisible ? 'password' : 'text');
        // Ubah ikon mata berdasarkan kondisi
        togglePassword.textContent = isPasswordVisible ? '👁‍🗨' : '👁'; 
    });
</script>
</body>
</html>