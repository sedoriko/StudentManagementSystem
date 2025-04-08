<?php
session_start();
include 'config.php';

// Redirect if not admin or not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch admin data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    // Validate current password if changing password
    if (!empty($new_password)) {
        if (!password_verify($current_password, $admin['password'])) {
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
    $email_check = $conn->prepare("SELECT user_id FROM users WHERE email = ? AND user_id != ?");
    $email_check->bind_param("si", $email, $user_id);
    $email_check->execute();
    if ($email_check->get_result()->num_rows > 0) {
        $errors[] = "Email already in use by another account";
    }

    if (empty($errors)) {
        // Prepare update query
        $update_fields = "name = ?, email = ?";
        $params = [$name, $email];
        $types = "ss";
        
        // Add password to update if changed
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_fields .= ", password = ?";
            $params[] = $hashed_password;
            $types .= "s";
        }
        
        $params[] = $user_id;
        $types .= "i";
        
        $sql = "UPDATE users SET $update_fields WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: admin_dashboard.php");
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
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .profile-container {
            max-width: 600px;
            margin: 3rem auto;
            background: rgba(255, 255, 255, 0.90);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .profile-header {
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-bottom: 4px solid rgba(255, 255, 255, 0.2);
        }
        .profile-body {
            padding: 2rem;
        }
        .form-control:focus {
            border-color: #4285f4;
            box-shadow: 0 0 0 0.25rem rgba(66, 133, 244, 0.25);
        }
        .btn-primary {
            background: linear-gradient(to right, #4285f4, #34a853);
            border: none;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-outline-secondary {
            transition: all 0.3s;
        }
        .btn-outline-secondary:hover {
            background-color: #f1f1f1;
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
                <h3><i class="fas fa-user-cog me-2"></i>Admin Profile Settings</h3>
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
                
                <form method="POST">
                    <div class="mb-4">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control form-control-lg" id="name" name="name" 
                               value="<?php echo htmlspecialchars($admin['name']); ?>" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" 
                               value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                    </div>
                    
                    <div class="password-section">
                        <h5 class="mb-4 text-center"><i class="fas fa-key me-2"></i>Password Settings</h5>
                        <p class="text-muted text-center mb-4">Leave blank to keep current password</p>
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password">
                                <span class="input-group-text toggle-password" style="cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password">
                                <span class="input-group-text toggle-password" style="cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                <span class="input-group-text toggle-password" style="cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                        <a href="admin_dashboard.php" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password visibility toggle
        document.querySelectorAll('.toggle-password').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const icon = this.querySelector('i');
                const input = this.parentElement.querySelector('input');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });
        
        // Form submission loading state
        document.querySelector('form').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>