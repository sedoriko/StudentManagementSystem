<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $password = $_POST['password'];

   // $sql = "SELECT * FROM users WHERE user_id='$user_id' AND email='$email'";
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: student_dashboard.php");
                exit();
            }
        } else {
            header("Location: login.php?error=invalid_password");
            exit();
        }
    } else {
        header("Location: login.php?error=user_not_found");
        exit();
    }

    $conn->close();
}
?>