<?php
include "config.php";

// Secure the student_id parameter
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($student_id <= 0) {
    header("Location: admin_dashboard.php?error=Invalid student ID");
    exit();
}

$result = $conn->query("SELECT * FROM students WHERE student_id=$student_id");
if ($result->num_rows === 0) {
    header("Location: admin_dashboard.php?error=Student not found");
    exit();
}
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Student Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .edit-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
        }
        .edit-header {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }
        .edit-header i {
            margin-right: 15px;
            color: #3498db;
            font-size: 1.8rem;
        }
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 5px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        .btn-update {
            background-color: #3498db;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        .btn-update:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .form-section {
            margin-bottom: 25px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        .form-section h5 {
            color: #3498db;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .required-field::after {
            content: " *";
            color: #e74c3c;
        }
        .student-id-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php include 'includes/admin_navbar.php'; ?>

    <div class="container">
        <div class="edit-container">
            <div class="edit-header">
                <i class="fas fa-user-edit"></i>
                <div>
                    <h2>Edit Student Information</h2>
                    <div class="student-id-badge">ID: <?php echo htmlspecialchars($row['student_id']); ?></div>
                </div>
            </div>

            <form action="update.php" method="post">
                <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($row['student_id']); ?>">

                <!-- Personal Information Section -->
                <div class="form-section">
                    <h5><i class="fas fa-user-circle me-2"></i>Personal Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Full Name</label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?php echo htmlspecialchars($row['name']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Email</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?php echo htmlspecialchars($row['email']); ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Birth Date</label>
                            <input type="date" name="birth_date" class="form-control" 
                                   value="<?php echo htmlspecialchars($row['birth_date']); ?>" required>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="form-section">
                    <h5><i class="fas fa-address-book me-2"></i>Contact Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Phone Number</label>
                            <input type="tel" name="phone_num" class="form-control" 
                                   value="<?php echo htmlspecialchars($row['phone_num']); ?>" 
                                   pattern="[0-9]{10,15}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Address</label>
                            <textarea name="address" class="form-control" rows="2" required><?php echo htmlspecialchars($row['address']); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Academic Information Section -->
                <div class="form-section">
                    <h5><i class="fas fa-graduation-cap me-2"></i>Academic Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">College</label>
                            <select name="college" class="form-select" id="college-select" required>
                                <option value="College of Engineering" <?php echo ($row['college'] == 'College of Engineering') ? 'selected' : ''; ?>>College of Engineering</option>
                                <option value="College of Science" <?php echo ($row['college'] == 'College of Science') ? 'selected' : ''; ?>>College of Science</option>
                                <option value="College of Liberal Arts" <?php echo ($row['college'] == 'College of Liberal Arts') ? 'selected' : ''; ?>>College of Liberal Arts</option>
                                <option value="College of Architecture and Fine Arts" <?php echo ($row['college'] == 'College of Architecture and Fine Arts') ? 'selected' : ''; ?>>College of Architecture and Fine Arts</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Course</label>
                            <select name="course" class="form-select" id="course-select" required>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Year Level</label>
                            <select name="year" class="form-select" id="year-select" required>
                                <option value="1" <?php echo ($row['year'] == '1') ? 'selected' : ''; ?>>1st Year</option>
                                <option value="2" <?php echo ($row['year'] == '2') ? 'selected' : ''; ?>>2nd Year</option>
                                <option value="3" <?php echo ($row['year'] == '3') ? 'selected' : ''; ?>>3rd Year</option>
                                <option value="4" <?php echo ($row['year'] == '4') ? 'selected' : ''; ?>>4th Year</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Section</label>
                            <select name="section" class="form-select" id="section-select" required>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Grades</label>
                            <select name="grades" class="form-select" required>
                                <?php
                                $grades = [0.00, 1.00, 1.25, 1.50, 1.75, 2.00, 2.25, 2.50, 2.75, 3.00, 5.00];
                                foreach ($grades as $grade) {
                                    $selected = ($row['grades'] == $grade) ? 'selected' : '';
                                    echo "<option value='$grade' $selected>$grade</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    
                    <button type="submit" class="btn btn-update">
                        <i class="fas fa-save me-2"></i>Update Student
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
            courseSelect.innerHTML = '';

            // Add new options based on selected college
            if (collegeCourses[selectedCollege]) {
                collegeCourses[selectedCollege].forEach(course => {
                    const option = new Option(course.text, course.value);
                    courseSelect.add(option);
                });
            }

            // Set the selected course from database
            const currentCourse = "<?php echo $row['course']; ?>";
            if (currentCourse) {
                courseSelect.value = currentCourse;
            }
        }

        // Function to populate sections based on selected year
        function populateSections() {
            const yearSelect = document.getElementById('year-select');
            const sectionSelect = document.getElementById('section-select');
            const selectedYear = yearSelect.value;

            // Clear existing options
            sectionSelect.innerHTML = '';

            // Add new options based on selected year
            if (yearSections[selectedYear]) {
                yearSections[selectedYear].forEach(section => {
                    const option = new Option(section, section);
                    sectionSelect.add(option);
                });
            }

            // Set the selected section from database
            const currentSection = "<?php echo $row['section']; ?>";
            if (currentSection) {
                sectionSelect.value = currentSection;
            }
        }

        // Initialize dropdowns on page load
        document.addEventListener('DOMContentLoaded', function() {
            populateCourses();
            populateSections();
        });

        // Event listeners for dynamic dropdowns
        document.getElementById('college-select').addEventListener('change', populateCourses);
        document.getElementById('year-select').addEventListener('change', populateSections);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>