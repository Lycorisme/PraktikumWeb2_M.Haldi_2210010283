<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum Web 2 - Modern Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 450px;
            width: 100%;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.6s ease forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .card-body {
            padding: 40px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-color);
            position: relative;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .login-header::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            margin: 15px auto;
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            color: var(--secondary-color);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            transition: all 0.3s ease;
        }

        .form-control {
            height: 50px;
            padding: 12px 20px;
            font-size: 15px;
            border: 2px solid #e1e5ee;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1);
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 40px;
            color: var(--secondary-color);
            transition: all 0.3s ease;
        }

        .password-toggle {
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            height: 50px;
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            background: #3756b5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login .spinner-border {
            display: none;
            position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -12px;
            margin-top: -12px;
        }

        .btn-login.loading {
            color: transparent;
        }

        .btn-login.loading .spinner-border {
            display: block;
        }

        .form-error {
            color: var(--danger-color);
            font-size: 13px;
            margin-top: 5px;
            display: none;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .input-error {
            border-color: var(--danger-color) !important;
        }

        .social-login {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e1e5ee;
        }

        .social-login p {
            color: var(--secondary-color);
            font-size: 14px;
            margin-bottom: 15px;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .google { background: #db4437; }
        .facebook { background: #4267B2; }
        .twitter { background: #1DA1F2; }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="login-header">
                    <h1>WELCOME BACK</h1>
                    <p class="text-muted">Please login to continue</p>
                </div>
                
                <form action="{{route('login.store')}}" method="post" id="loginForm">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" autocomplete="off">
                        <i class="fas fa-user input-icon"></i>
                        <div class="form-error">Please enter a valid username</div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <i class="fas fa-eye password-toggle input-icon"></i>
                        <div class="form-error">Password is required</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="#" class="text-primary text-decoration-none">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <span class="btn-text">Login</span>
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const passwordToggle = document.querySelector('.password-toggle');
            const passwordInput = document.getElementById('password');

            // Password visibility toggle
            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            // Form validation and submission
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const username = document.getElementById('username').value.trim();
                const password = passwordInput.value.trim();
                let isValid = true;

                // Reset previous errors
                document.querySelectorAll('.form-error').forEach(error => error.style.display = 'none');
                document.querySelectorAll('.form-control').forEach(input => input.classList.remove('input-error'));

                // Validate username
                if (!username) {
                    document.querySelector('#username').classList.add('input-error');
                    document.querySelector('#username').nextElementSibling.nextElementSibling.style.display = 'block';
                    isValid = false;
                }

                // Validate password
                if (!password) {
                    document.querySelector('#password').classList.add('input-error');
                    document.querySelector('#password').nextElementSibling.nextElementSibling.style.display = 'block';
                    isValid = false;
                }

                if (isValid) {
                    // Show loading state
                    const submitBtn = document.querySelector('.btn-login');
                    submitBtn.classList.add('loading');
                    
                    // Simulate API call
                    setTimeout(() => {
                        // Here you would typically make your actual API call
                        submitBtn.classList.remove('loading');
                        
                        // Show success message
                        Swal.fire({
                            title: 'Welcome Back!',
                            text: 'Login successful',
                            icon: 'success',
                            customClass: {
                                popup: 'swal2-show',
                                title: 'text-xl font-bold mb-4',
                                confirmButton: 'btn btn-primary px-4'
                            },
                            buttonsStyling: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            // Submit the form
                            loginForm.submit();
                        });
                    }, 1500);
                }
            });

            // Input focus effects
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.querySelector('label').style.color = 'var(--primary-color)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.querySelector('label').style.color = 'var(--secondary-color)';
                });
            });
        });
    </script>
</body>
</html>