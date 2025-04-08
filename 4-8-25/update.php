<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $college = $_POST['college'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $birth_date = $_POST['birth_date'];
    $phone_num = $_POST['phone_num'];
    $address = $_POST['address'];
    $grades = $_POST['grades'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update the students table
        $sql = "UPDATE students SET 
                name = ?, 
                email = ?, 
                college = ?, 
                course = ?, 
                year = ?, 
                section = ?, 
                birth_date = ?, 
                phone_num = ?, 
                address = ?, 
                grades = ? 
                WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssdi", $name, $email, $college, $course, $year, $section, $birth_date, $phone_num, $address, $grades, $student_id);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();

        header("Location: admin_dashboard.php?message=Student updated successfully");
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        echo "Error updating record: " . $e->getMessage();
    }

    $conn->close();
}
?>