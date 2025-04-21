<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --dark-bg: rgba(0, 0, 0, 0.7);  /* Lighter dark gradient */
            --light-bg: rgba(255, 255, 255, 0.25);
            --text-light: #f8f9fa;
            --text-dark: #212529;
            --border-color: rgba(255, 255, 255, 0.1);
        }
        
        body {
            background-image: url('background/login_register.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-light);
        }
        
        .register-container {
            max-width: 800px;
            margin: 2rem auto;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .register-card {
            background: linear-gradient(145deg, var(--dark-bg), var(--light-bg));
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(29, 28, 28, 0.3);
            overflow: hidden;
            backdrop-filter: blur(5px);
            border: 1px solid var(--border-color);
        }
        
        .card-header {
            background: linear-gradient(145deg, var(--dark-bg), var(--light-bg));
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .logo-img {
            width: 50px;
            height: auto;
            position: absolute;
            left: 20px;
        }
        
        .card-header h3 {
            margin: 0;
            font-weight: 600;
            width: 100%;
        }
        
        .form-container {
            padding: 2rem;
        }
        
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            border-left: 4px solid white;
        }
        
        .form-section h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .form-section h5 i {
            margin-right: 10px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: white;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .btn-register {
            background: linear-gradient(145deg, var(--dark-bg), var(--light-bg));
            border: 1px solid white;
            color: white;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background: linear-gradient(145deg, var(--light-bg), var(--dark-bg));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }
        
        .input-group {
            position: relative;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 1.5rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .footer-links a:hover {
            color: white;
            text-decoration: underline;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .register-container {
                margin: 1rem;
            }
            
            .card-header {
                flex-direction: column;
                text-align: center;
            }
            
            .logo-img {
                position: relative;
                left: auto;
                margin-bottom: 10px;
            }
        }

        .card-footer {
            color: white !important;
            border-top: 1px solid var(--border-color);
        }
        
        .card-footer a {
            color: white !important;
            text-decoration: underline;
        }
        
        .card-footer a:hover {
            opacity: 0.8;
        }

        .form-check-label {
            color: white !important;
            opacity: 0.9;
        }
        
        .form-check-label i {
            color: white !important;
            opacity: 0.8;
        }

        .form-select {
            background-color: rgba(255, 255, 255, 0.15); /* Match the dark design */
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
        }

        /* Successful Registration Modal */
        .modal-content {
            background: linear-gradient(145deg, var(--dark-bg), var(--light-bg));
            color: white;
        }

        .modal-header {
            background: linear-gradient(145deg, var(--dark-bg), var(--dark-bg));
            color: white;
        }

        .modal-body h4 {
            color: white;
            font-weight: 600;
        }

        .modal-body p {
            color: rgba(255, 255, 255, 0.7);
        }

        .modal-footer a {
            background: linear-gradient(145deg, var(--dark-bg), var(--dark-bg));
            border: 1px solid white;
            color: white;
            padding: 10px 30px;
            font-weight: 600;
        }

        .modal-footer a:hover {
            background: linear-gradient(145deg, var(--light-bg), var(--dark-bg));
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>
<body>
    <!-- Success Modal -->
    <div class="modal fade success-modal" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registration Successful!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-check-circle"></i>
                    <h4>Account Created Successfully</h4>
                    <p>Your registration has been completed. You can now login to your account.</p>
                    <a href="login.php" class="btn btn-success mt-3 px-4">
                        Go to Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
            <?php 
            $errors = explode(",", $_GET['error']);
            foreach ($errors as $error) {
                echo htmlspecialchars($error) . "<br>";
            }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="register-card card">
                    <div class="card-header text-center">
                        <h3><i class="fas fa-user-plus me-2"></i>Create Account</h3>
                    </div>
                    <div class="form-container">
                        <form id="registration-form" action="register_process.php" method="post">
                            <!-- Role Selection -->
                            <div class="mb-4">
                                <label class="form-label required-field">I am registering as:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="role-admin" value="admin" required>
                                        <label class="form-check-label" for="role-admin">
                                            <i class="fas fa-user-shield me-2"></i>Administrator
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="role-student" value="student">
                                        <label class="form-check-label" for="role-student">
                                            <i class="fas fa-user-graduate me-2"></i>Student
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Basic Information -->
                            <div class="form-section">
                                <h5><i class="fas fa-id-card me-2"></i>Basic Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required-field">Full Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required-field">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="example@school.edu" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required-field">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Create password" required>
                                            <span class="password-toggle" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <small class="text-muted-white">Minimum 8 characters</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required-field">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
                                            <span class="password-toggle" id="toggleConfirmPassword">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Student Information (Hidden by Default) -->
                            <div id="student-fields" style="display: none;">
                                <div class="form-section">
                                    <h5><i class="fas fa-graduation-cap me-2"></i>Student Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">Birth Date</label>
                                            <input type="date" name="birth_date" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">Phone Number</label>
                                            <input type="tel" name="phone_num" class="form-control" placeholder="09123456789" pattern="[0-9]{10,15}">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required-field">Address</label>
                                        <textarea name="address" class="form-control" rows="3" placeholder="Complete address"></textarea>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h5><i class="fas fa-university me-2"></i>Academic Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">College</label>
                                            <select name="college" class="form-select" id="college-select">
                                                <option value="" selected disabled>Select College</option>
                                                <option value="College of Engineering">College of Engineering</option>
                                                <option value="College of Science">College of Science</option>
                                                <option value="College of Liberal Arts">College of Liberal Arts</option>
                                                <option value="College of Architecture and Fine Arts">College of Architecture and Fine Arts</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required-field">Course</label>
                                            <select name="course" class="form-select" id="course-select">
                                                <option value="" selected disabled>Select College first</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-register btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Register
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        Already have an account? <a href="login.php" class="text-success">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // College-Course relationship
        const collegeCourses = {
            "College of Engineering": [
                {value: "Bachelor of Science in Civil Engineering", text: "BSCE - Civil Engineering"},
                {value: "Bachelor of Science in Electrical Engineering", text: "BSEE - Electrical Engineering"},
                {value: "Bachelor of Science in Electronics Engineering", text: "BSECE - Electronics Engineering"},
                {value: "Bachelor of Science in Mechanical Engineering", text: "BSME - Mechanical Engineering"}
            ],
            "College of Science": [
                {value: "Bachelor of Science in Computer Science", text: "BSCS - Computer Science"},
                {value: "Bachelor of Science in Environmental Science", text: "BSES - Environmental Science"},
                {value: "Bachelor of Science in Information System", text: "BSIS - Information System"},
                {value: "Bachelor of Science in Information Technology", text: "BSIT - Information Technology"}
            ],
            "College of Liberal Arts": [
                {value: "Bachelor of Science in Management", text: "BSM - Management"},
                {value: "Bachelor of Science in Entrepreneurship Management", text: "BSEM - Entrepreneurship Management"},
                {value: "Bachelor of Science in Hospitality Management", text: "BSHM - Hospitality Management"}
            ],
            "College of Architecture and Fine Arts": [
                {value: "Bachelor of Science in Architecture", text: "BSARCH - Architecture"},
                {value: "Bachelor of Fine Arts", text: "BFA - Fine Arts"},
                {value: "Bachelor in Graphics Technology", text: "BGT - Graphics Technology"}
            ]
        };

        // Update courses when college changes
        document.getElementById('college-select').addEventListener('change', function() {
            const courseSelect = document.getElementById('course-select');
            courseSelect.innerHTML = '<option value="" selected disabled>Select Course</option>';
            
            if (this.value && collegeCourses[this.value]) {
                collegeCourses[this.value].forEach(course => {
                    const option = new Option(course.text, course.value);
                    courseSelect.add(option);
                });
            }
        });

        // Show/hide student fields based on role
        document.querySelectorAll('input[name="role"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const studentFields = document.getElementById('student-fields');
                if (this.value === 'student') {
                    studentFields.style.display = 'block';
                    // Make student fields required
                    document.querySelectorAll('#student-fields [required]').forEach(field => {
                        field.required = true;
                    });
                } else {
                    studentFields.style.display = 'none';
                    // Remove required from student fields
                    document.querySelectorAll('#student-fields [required]').forEach(field => {
                        field.required = false;
                    });
                }
            });
        });

        // Password visibility toggle
        function setupPasswordToggle(inputId, toggleId) {
            const passwordInput = document.getElementById(inputId);
            const toggleButton = document.getElementById(toggleId);
            
            toggleButton.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        }

        // Initialize password toggles
        setupPasswordToggle('password', 'togglePassword');
        setupPasswordToggle('confirm_password', 'toggleConfirmPassword');

        // Client-side validation
        document.getElementById('registration-form').addEventListener('submit', function(event) {
            const password = this.password.value;
            const confirmPassword = this.confirm_password.value;
            const role = this.querySelector('input[name="role"]:checked')?.value;

            if (password !== confirmPassword) {
                event.preventDefault();
                alert('Passwords do not match!');
                return;
            }

            if (password.length < 8) {
                event.preventDefault();
                alert('Password must be at least 8 characters long!');
                return;
            }

            if (role === 'student') {
                const birthDate = this.birth_date.value;
                const phoneNum = this.phone_num.value;
                const address = this.address.value;
                const college = this.college.value;
                const course = this.course.value;

                if (!birthDate || !phoneNum || !address || !college || !course) {
                    event.preventDefault();
                    alert('Please fill in all required student information!');
                    return;
                }
            }
        });

        // Show success modal if registration was successful
        <?php if (isset($_GET['success'])): ?>
        document.addEventListener('DOMContentLoaded', function() {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            
            // Change URL to remove the success parameter
            history.replaceState(null, null, window.location.pathname);
        });
        <?php endif; ?>
    </script>
</body>
</html>