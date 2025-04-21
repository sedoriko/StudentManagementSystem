<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color:rgb(119, 118, 118), 0);
            --primary-hover:rgb(129, 129, 129);
            --text-color: #495057;
            --light-gray: #f8f9fa;
        }
        
        body {
            background-image: url('background/login_register.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            max-width: 450px;
            width: 100%;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .login-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(0, 0, 0, 0.1));
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border: none;
        }
        
        .card-header {
            background: linear-gradient(145deg, rgba(0, 0, 0, 0.8), rgba(255, 255, 255, 0.1));
            color: white;
            padding: 0.5rem;
            border-bottom: none;
            display: flex;
            justify-content: center; /* Center the content horizontally */
            align-items: center; /* Vertically align the content */
            position: relative;
        }

        .logo-img {
            width: 50px; /* Adjust the size of the logo */
            height: auto;
            position: absolute;
            left: 10px; /* Position the logo to the left */
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
            text-align: center; /* Center the text */
            width: 100%; /* Take up full width to keep the text centered */
        }

        .card-body {
            padding: 2rem;
        }
        
        .form-control {
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(18, 20, 19, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(145deg, rgba(0, 0, 0, 0.8), rgba(255, 255, 255, 0.1));
            border: none;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            color: white;
        }
        
        .btn-login:hover {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.1), rgba(0, 0, 0, 0.8));
            transform: translateY(-2px);
        }
        
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-color);
        }
        
        .input-group {
            position: relative;
        }
        
        .footer-links {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
        
        .footer-links a {
            color: var(--light-gray);
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Big title style */
        .university-title {
            font-family: 'Noto Serif', serif;
            font-weight: bold;
            font-size: 4rem;
            text-align: center;
            color: white;
            margin-top: 1px;
            margin-bottom: 25px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-container {
                padding: 0 15px;
            }
            .card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- University Title -->
        <a href="landing_page.php">
            <img src="background/logo.jpg" alt="University Logo" style="width: 110px; height: auto; position: absolute; top: 10px; left: 50%; transform: translateX(-50%); cursor: pointer;">
        </a>
        <div class="university-title">
            Philippine University of Technology
        </div>

        <div class="row justify-content-center">
            <div class="login-container">
                <div class="login-card card">
                    <div class="card-header">
                        <img src="background/logo.jpg" alt="Logo" class="logo-img me-5" />
                        <h3>Welcome Back</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <div>
                                        <?php
                                        switch ($_GET['error']) {
                                            case 'invalid_password':
                                                echo "The password you entered is incorrect.";
                                                break;
                                            case 'user_not_found':
                                                echo "No account found with this email address.";
                                                break;
                                            case 'inactive_account':
                                                echo "Your account is inactive. Please contact support.";
                                                break;
                                            case 'session_expired':
                                                echo "Your session has expired. Please login again.";
                                                break;
                                            default:
                                                echo "An error occurred during login. Please try again.";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <div>
                                        <?php
                                        switch ($_GET['success']) {
                                            case 'registered':
                                                echo "Registration successful! Please login with your credentials.";
                                                break;
                                            case 'password_updated':
                                                echo "Password updated successfully! Please login with your new password.";
                                                break;
                                            case 'logged_out':
                                                echo "You have been successfully logged out.";
                                                break;
                                            default:
                                                echo "Action completed successfully. Please login.";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form action="login_process.php" method="post" id="loginForm">
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                                    <span class="password-toggle" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-login btn-lg">
                                    Login
                                </button>
                            </div>
                            
                            <div class="footer-links">
                                <a href="register.php">Create Account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
        
        // Form submission animation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Logging in...';
            btn.disabled = true;
        });
        
        // Auto-focus email field on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
        });
    </script>
</body>
</html>
