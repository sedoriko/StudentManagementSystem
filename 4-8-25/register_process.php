<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Server-side validation
    $errors = [];

    if (empty($name)) {
        $errors[] = "Full Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Password and confirmation do not match";
    }
    if ($role === 'student') {
        if (empty($_POST['birth_date'])) {
            $errors[] = "Birth Date is required";
        }
        if (empty($_POST['phone_num'])) {
            $errors[] = "Phone Number is required";
        }
        if (empty($_POST['address'])) {
            $errors[] = "Address is required";
        }
        if (empty($_POST['college'])) {
            $errors[] = "College is required";
        }
        if (empty($_POST['course'])) {
            $errors[] = "Course is required";
        }
    }

    // If there are errors, redirect back with error messages
    if (!empty($errors)) {
        header("Location: register.php?error=" . urlencode(implode(",", $errors)));
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: register.php?error=Email already registered. Please use a different email");
        exit();
    }

    // Insert into users table
    $sql = "INSERT INTO users (role, name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $role, $name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        // If student, insert into students table
        if ($role == 'student') {
            $birth_date = $_POST['birth_date'];
            $phone_num = $_POST['phone_num'];
            $address = $_POST['address'];
            $college = $_POST['college'];
            $course = $_POST['course'];

            $sql = "INSERT INTO students (user_id, name, email, password, birth_date, phone_num, address, college, course) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssssss", $user_id, $name, $email, $hashed_password, $birth_date, $phone_num, $address, $college, $course);
            $stmt->execute();
        }

        // Redirect with success message
        header("Location: register.php?success=1");
        exit();
    } else {
        header("Location: register.php?error=Registration failed. Please try again");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: register.php");
    exit();
}
?>