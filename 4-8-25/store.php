<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $college = $_POST['college'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $birth_date = $_POST['birth_date'];
    $phone_num = $_POST['phone_num'];
    $address = $_POST['address'];
    $grades = $_POST['grades']; // Ensure this field is included in the form

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert into users table
        $sql = "INSERT INTO users (role, name, email, password) VALUES ('student', ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);
        $stmt->execute();
        $user_id = $stmt->insert_id; // Get the generated user_id
        $stmt->close();

        // Insert into students table
        $sql = "INSERT INTO students (user_id, name, email, password, college, course, year, section, birth_date, phone_num, address, grades) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssssssd", $user_id, $name, $email, $password, $college, $course, $year, $section, $birth_date, $phone_num, $address, $grades);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();

        header("Location: admin_dashboard.php?message=Student added successfully");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        
        // Sanitize the error message (optional: avoid exposing too much detail)
        $error = urlencode("Email already registered. Please use a different email.");
        header("Location: create.php?error=$error");
        exit();
    }

    $conn->close();
}
