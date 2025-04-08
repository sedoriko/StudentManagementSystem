<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

    // Update email
    $sql = "UPDATE students SET email='$email' WHERE user_id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        // Update password if provided
        if ($password) {
            $sql = "UPDATE students SET password='$password' WHERE user_id='$user_id'";
            if ($conn->query($sql) !== TRUE) {
                echo "Error updating password: " . $conn->error;
            }
        }
        echo "Profile updated successfully!";
        header("Location: student_dashboard.php");
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $conn->close();
}
?>