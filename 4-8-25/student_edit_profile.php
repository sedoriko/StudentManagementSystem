<?php
session_start();
include 'config.php';

// Redirect if not student or not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}

// Fetch student data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM students WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    // Validate current password if changing password
    if (!empty($new_password)) {
        if (!password_verify($current_password, $student['password'])) {
            $errors[] = "Current password is incorrect";
        }
        if ($new_password !== $confirm_password) {
            $errors[] = "New passwords don't match";
        }
        if (strlen($new_password) < 8) {
            $errors[] = "Password must be at least 8 characters";
        }
    }

    // Check if email exists (excluding current user)
    $email_check = $conn->prepare("SELECT user_id FROM students WHERE email = ? AND user_id != ?");
    $email_check->bind_param("si", $email, $user_id);
    $email_check->execute();
    if ($email_check->get_result()->num_rows > 0) {
        $errors[] = "Email already in use by another account";
    }

    if (empty($errors)) {
        // Prepare update query
        $update_fields = "email = ?";
        $params = [$email];
        $types = "s";
        
        // Add password to update if changed
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_fields .= ", password = ?";
            $params[] = $hashed_password;
            $types .= "s";
        }
        
        $params[] = $user_id;
        $types .= "i";
        
        $sql = "UPDATE students SET $update_fields WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            // Update session password if changed
            if (!empty($new_password)) {
                $_SESSION['password_updated'] = true;
            }
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: student_dashboard.php");
            exit();
        } else {
            $errors[] = "Error updating profile: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --primary-green: #2e7d32; 
            --dark-green: #1b5e20;
            --light-green: #e8f5e9;
        }
        
        body {
            background-image: url('background/student_background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .profile-container {
            max-width: 650px;
            margin: 3rem auto;
            background: rgba(255, 255, 255, 0.80);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .profile-header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-bottom: 4px solid rgba(255, 255, 255, 0.2);
        }
        
        .profile-body {
            padding: 2rem;
        }
        
        .info-section {
            background-color: rgba(232, 245, 233, 0.3);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-green);
        }
        
        .info-item {
            margin-bottom: 0.8rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--dark-green);
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.25);
        }
        
        .btn-save {
            background: linear-gradient(to right, var(--primary-blue), #34a853);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .password-section {
            background-color: rgba(241, 243, 244, 0.5);
            padding: 1.5rem;
            border-radius: 10px;
            margin: 1.5rem 0;
        }
        
        .error-list {
            list-style-type: none;
            padding-left: 0;
        }
        
        .error-list li:before {
            content: "⚠️ ";
        }
        
        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #5f6368;
        }
        
        .input-group {
            position: relative;
        }
        
        @media (max-width: 768px) {
            .profile-container {
                margin: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="profile-container">
            <div class="profile-header">
                <h3><i class="fas fa-user-edit me-2"></i>Student Profile Settings</h3>
            </div>
            <div class="profile-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="error-list mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="info-section">
                    <h5 class="mb-4 text-center"><i class="fas fa-id-card me-2"></i>Student Information</h5>
                    <div class="info-item">
                        <span class="info-label">Name:</span> <?php echo htmlspecialchars($student['name']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Student ID:</span> <?php echo htmlspecialchars($student['student_id']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Course:</span> <?php echo htmlspecialchars($student['course']); ?>
                    </div>
                    <div class="info-item">
                        <span class="info-label">College:</span> <?php echo htmlspecialchars($student['college']); ?>
                    </div>
                </div>
                
                <form method="POST">
                    <h5 class="mb-4"><i class="fas fa-edit me-2"></i>Editable Information</h5>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" 
                               value="<?php echo htmlspecialchars($student['email']); ?>" required>
                    </div>
                    
                    <div class="password-section">
                        <h5 class="mb-4 text-center"><i class="fas fa-key me-2"></i>Change Password</h5>
                        <p class="text-muted text-center mb-4">Leave blank to keep current password</p>
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password">
                                <span class="toggle-password" id="toggleCurrentPassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password">
                                <span class="toggle-password" id="toggleNewPassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                <span class="toggle-password" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-save btn-lg">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                        <a href="student_dashboard.php" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password visibility toggles
        function setupPasswordToggle(inputId, toggleId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            
            toggle.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        }
        
        // Initialize all password toggles
        setupPasswordToggle('current_password', 'toggleCurrentPassword');
        setupPasswordToggle('new_password', 'toggleNewPassword');
        setupPasswordToggle('confirm_password', 'toggleConfirmPassword');
        
        // Form submission loading state
        document.querySelector('form').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>