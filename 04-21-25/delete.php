<?php
include 'config.php';

// Check if the student ID is set in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $conn->begin_transaction();

    try {
        $sql = "SELECT user_id FROM students WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $stmt->close();

            // Delete the student from the students table
            $sql = "DELETE FROM students WHERE student_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $stmt->close();

            // Delete the user from the users table
            $sql = "DELETE FROM users WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();

            $conn->commit();
            header("Location: admin_dashboard.php?success=Student deleted successfully");
            exit();
        } else {
            // Student not found
            header("Location: admin_dashboard.php?error=Student not found");
            exit();
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        header("Location: admin_dashboard.php?error=Error deleting student: " . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: admin_dashboard.php?error=No student ID provided");
    exit();
}

// Close the database connection
$conn->close();
?>