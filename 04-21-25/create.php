<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-image: url('background/admin_background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin: 30px auto;
            max-width: 900px;
        }
        .form-header {
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-header i {
            margin-right: 15px;
            font-size: 2rem;
        }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4285f4;
            box-shadow: 0 0 0 0.25rem rgba(66, 133, 244, 0.25);
        }
        .btn-submit {
            background: linear-gradient(to right, #4285f4, #34a853);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        .btn-back {
            background: linear-gradient(to right, #f1f3f4, #e8eaed);
            border: none;
            padding: 12px 25px;
            font-weight: 600;
            color: #2c3e50;
            transition: all 0.3s;
            margin-right: 15px;
        }
        .btn-back:hover {
            background: linear-gradient(to right, #e8eaed, #dadce0);
            color: #1a73e8;
        }
        .form-section {
            margin-bottom: 30px;
            padding: 25px;
            background-color: rgba(241, 243, 244, 0.5);
            border-radius: 10px;
            border-left: 4px solid #4285f4;
        }
        .form-section h5 {
            color: #1a73e8;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        .form-section h5 i {
            margin-right: 10px;
        }
        .required-field::after {
            content: " *";
            color: #e74c3c;
        }
        .toggle-password {
            cursor: pointer;
            background-color: #f1f3f4;
            border: 1px solid #ced4da;
            border-left: none;
            border-radius: 0 8px 8px 0;
        }
        .toggle-password:hover {
            background-color: #e8eaed;
        }
        .button-group {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }
        @media (max-width: 768px) {
            .form-container {
                margin: 15px;
                padding: 20px;
            }
            .form-header {
                padding: 1rem;
            }
            .button-group {
                flex-direction: column-reverse;
                gap: 10px;
            }
            .btn-back, .btn-submit {
                width: 100%;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="form-container">
            <div class="form-header">
                <i class="fas fa-user-graduate"></i>
                <h2 class="mb-0">Add New Student</h2>
            </div>

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

            <form action="store.php" method="post">
                <!-- Personal Information Section -->
                <div class="form-section">
                    <h5><i class="fas fa-user-circle"></i>Personal Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="student@example.com" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Create Password" required>
                                <button class="btn toggle-password" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Birth Date</label>
                            <input type="date" name="birth_date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="form-section">
                    <h5><i class="fas fa-address-book"></i>Contact Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Phone Number</label>
                            <input type="tel" name="phone_num" class="form-control" placeholder="09123456789" pattern="[0-9]{10,15}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Address</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Complete Address" required></textarea>
                        </div>
                    </div>
                </div>

                <!-- Academic Information Section -->
                <div class="form-section">
                    <h5><i class="fas fa-graduation-cap"></i>Academic Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">College</label>
                            <select name="college" class="form-select" id="college-select" required>
                                <option value="" selected disabled>Select College</option>
                                <option value="College of Engineering">College of Engineering</option>
                                <option value="College of Science">College of Science</option>
                                <option value="College of Liberal Arts">College of Liberal Arts</option>
                                <option value="College of Architecture and Fine Arts">College of Architecture and Fine Arts</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Course</label>
                            <select name="course" class="form-select" id="course-select" required>
                                <option value="" selected disabled>Select College first</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Year Level</label>
                            <select name="year" class="form-select" id="year-select" required>
                                <option value="" selected disabled>Select Year Level</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Section</label>
                            <select name="section" class="form-select" id="section-select" required>
                                <option value="" selected disabled>Select Year first</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Grades</label>
                            <select name="grades" class="form-select" required>
                                <option value="" selected disabled>Select Grade</option>
                                <?php
                                $grades = [0.00, 1.00, 1.25, 1.50, 1.75, 2.00, 2.25, 2.50, 2.75, 3.00, 5.00];
                                foreach ($grades as $grade) {
                                    echo "<option value='$grade'>$grade</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <a href="admin_dashboard.php" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <button type="submit" class="btn btn-submit btn-lg">
                        <i class="fas fa-save me-2"></i>Submit Student Record
                    </button>
                </div>
            </form>
        </div>
    </div>

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

        // Year-Section relationship
        const yearSections = {
            "1": ["1A", "1B", "1C", "1D", "1E"],
            "2": ["2A", "2B", "2C", "2D", "2E"],
            "3": ["3A", "3B", "3C", "3D", "3E"],
            "4": ["4A", "4B", "4C", "4D", "4E"]
        };

        // Function to populate courses based on selected college
        function populateCourses() {
            const collegeSelect = document.getElementById('college-select');
            const courseSelect = document.getElementById('course-select');
            const selectedCollege = collegeSelect.value;

            // Clear existing options
            courseSelect.innerHTML = '<option value="" selected disabled>Select Course</option>';

            // Add new options based on selected college
            if (collegeCourses[selectedCollege]) {
                collegeCourses[selectedCollege].forEach(course => {
                    const option = new Option(course.text, course.value);
                    courseSelect.add(option);
                });
            }
        }

        // Function to populate sections based on selected year
        function populateSections() {
            const yearSelect = document.getElementById('year-select');
            const sectionSelect = document.getElementById('section-select');
            const selectedYear = yearSelect.value;

            // Clear existing options
            sectionSelect.innerHTML = '<option value="" selected disabled>Select Section</option>';

            // Add new options based on selected year
            if (yearSections[selectedYear]) {
                yearSections[selectedYear].forEach(section => {
                    const option = new Option(section, section);
                    sectionSelect.add(option);
                });
            }
        }

        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Event listeners
        document.getElementById('college-select').addEventListener('change', populateCourses);
        document.getElementById('year-select').addEventListener('change', populateSections);
        
        // Form submission loading state
        document.querySelector('form').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...';
            submitBtn.disabled = true;
        });

        
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>