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
            width: 450px;
            padding: 20px;
        }

        .banner img {
            width: 100%;
            height: auto;
        }

        /* Form */
        .login-form {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #333333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
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
            font-size: 16px;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background-color: #2A7296;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #246480;
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #2A7296;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Pesan Error */
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            display: none;
        }
    </style>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Token CSRF untuk Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="login-container">
        <div class="banner">
            <img src="{{ asset('img/loginicon.jpg') }}" alt="PLN Icon Plus Banner">
        </div>
        <form id="login-form" class="login-form">
            <div class="error-message" id="error-message">Username atau password salah!</div>
            <div class="form-group">
                <label for="username">ID Karyawan/Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                    <span class="toggle-password">👁</span>
                </div>
            </div>
            <button type="submit" class="login-button">Login</button>
            <a href="#" class="forgot-password">Forgot password?</a>
        </form>
    </div>

    <script>
    // Toggle password visibility
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.querySelector('#password');

    togglePassword.addEventListener('click', () => {
        const isPasswordVisible = passwordInput.getAttribute('type') === 'text';
        passwordInput.setAttribute('type', isPasswordVisible ? 'password' : 'text');
        togglePassword.textContent = isPasswordVisible ? '👁‍🗨' : '👁';
    });

    // AJAX Login ke Laravel dengan Debugging
    $(document).ready(function () {
        $("#login-form").on("submit", function (event) {
            event.preventDefault(); // Mencegah reload

            var username = $("#username").val();
            var password = $("#password").val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil CSRF token dari meta tag

            // Debugging: Cek data sebelum dikirim
            console.log("🔍 Mengirim data login...");
            console.log("Username:", username);
            console.log("Password:", password);
            console.log("CSRF Token:", csrfToken);

            $.ajax({
                url: "{{ route('login.post') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Kirim token CSRF
                },
                data: {
                    username: username,
                    password: password
                },
                success: function (response) {
                    console.log("✅ Login berhasil!", response); // Debugging: Lihat respons server

                    if (response.redirect) {
                        console.log("🔀 Redirecting to:", response.redirect);
                        window.location.href = response.redirect;
                    }
                },
                error: function (xhr, status, error) {
                    console.error("❌ Login gagal!");
                    console.error("Status:", status);
                    console.error("Error:", error);
                    console.error("Response:", xhr.responseText); // Debugging: Lihat respons server jika error

                    $("#error-message").text("Username atau password salah!").show();
                }
            });
        });
    });
</script>

</body>
</html>
