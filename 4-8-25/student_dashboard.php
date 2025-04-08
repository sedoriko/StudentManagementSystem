<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}
include 'config.php';
include 'includes/student_navbar.php';

// Fetch student data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM students WHERE user_id='$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('background/student_background.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .welcome-message {
            color:rgb(252, 252, 252);
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 25px;
            margin-top: 10px;
        }

        .info-section {
            background-color: rgba(255, 255, 255, 0.81);
            border-left: 5px solid #2e7d32;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .info-header {
            color: #2e7d32;
            border-bottom: 2px solid #388e3c;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .info-item {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: 600;
            color: #4e5d52;
        }

        .info-value {
            color: #212529;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h2 class="welcome-message">
            Welcome, <?php echo htmlspecialchars($row['name']); ?> 
            <span class="text-light fw-normal">(<?php echo htmlspecialchars($row['student_id']); ?>)</span>
        </h2>
        
        <div class="row"> 
            <!-- Academic Information Section -->
            <div class="col-md-6 mb-4">
                <div class="info-section">
                    <h4 class="info-header">Academic Information</h4>
                    <div class="info-item">
                        <span class="info-label">Student ID:</span>
                        <span class="info-value"><?php echo htmlspecialchars($row['student_id']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <span class="info-value"><?php echo htmlspecialchars($row['name']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">College:</span>
                        <span class="info-value"><?php echo htmlspecialchars($row['college']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Course:</span>
                        <span class="info-value"><?php echo htmlspecialchars($row['course']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Grades:</span>
                        <span class="info-value"><?php echo htmlspecialchars($row['grades']); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Personal Information Section -->
            <div class="col-md-6 mb-4">
                <div class="info-section">
                    <h4 class="info-header">Personal Information</h4>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($row['email']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Birth Date:</span>
                        <span class="info-value"><?php echo htmlspecialchars($row['birth_date']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone Number:</span>
                        <span class="info-value"><?php echo htmlspecialchars($row['phone_num']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Address:</span>
                        <span class="info-value"><?php echo htmlspecialchars($row['address']); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
