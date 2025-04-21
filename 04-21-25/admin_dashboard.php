<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
include 'config.php';
include 'includes/admin_navbar.php';

// Fetch admin details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Determine current sort order
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'student_id';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-image: url('background/admin_background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .dashboard-container {
            background-color: rgba(255, 255, 255, 0.90  );
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 30px;
            margin-top: 30px;
            margin-bottom: 50px;
        }
        .welcome-header {
            color: #2c3e50;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }
        .student-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
        }
        .student-table th {
            background-color: #3498db;
            color: white;
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            border: none;
        }
        .student-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e9ecef;
            background-color: rgba(255, 255, 255, 0.8);
        }
        .student-table tr:hover td {
            background-color: #f8f9fa;
        }
        .student-name {
            font-weight: 500;
            color: #2980b9;
            text-decoration: none;
        }
        .student-name:hover {
            text-decoration: underline;
            color: #1a5276;
        }
        .action-btn {
            transition: all 0.3s ease;
            font-size: 1.1em;
        }
        .delete-btn {
            color: #e74c3c;
        }
        .delete-btn:hover {
            color: #c0392b;
            transform: scale(1.1);
        }
        .sort-btn {
            background-color: #e9ecef;
            border: none;
            padding: 6px 12px;
            margin-right: 5px;
            border-radius: 4px;
            font-size: 0.9em;
            transition: all 0.2s;
        }
        .sort-btn:hover {
            background-color: #d6d8db;
        }
        .sort-btn.active {
            background-color: #3498db;
            color: white;
        }
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .add-btn {
            background-color: #2ecc71;
            border: none;
            padding: 8px 16px;
            font-weight: 500;
        }
        .add-btn:hover {
            background-color: #27ae60;
            transform: translateY(-1px);
        }
        @media (max-width: 768px) {
            .table-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .sort-options {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="container py-4">
        <div class="dashboard-container">
            <h2 class="welcome-header">Welcome, <?php echo htmlspecialchars($row['name']); ?>!</h2>
            
            <div class="table-header">
                <a href="create.php" class="btn btn-primary add-btn">
                    <i class="fas fa-plus me-2"></i>Add New Student
                </a>
                <div class="sort-options">
                    <span class="me-2 text-muted">Sort by:</span>
                    <a href="?sort=student_id&order=<?php echo $sort == 'student_id' && $order == 'asc' ? 'desc' : 'asc' ?>" 
                       class="sort-btn <?php echo $sort == 'student_id' ? 'active' : '' ?>">
                        ID <i class="fas fa-sort<?php echo $sort == 'student_id' ? '-' . ($order == 'asc' ? 'up' : 'down') : '' ?> ms-1"></i>
                    </a>
                    <a href="?sort=name&order=<?php echo $sort == 'name' && $order == 'asc' ? 'desc' : 'asc' ?>" 
                       class="sort-btn <?php echo $sort == 'name' ? 'active' : '' ?>">
                        Name <i class="fas fa-sort<?php echo $sort == 'name' ? '-' . ($order == 'asc' ? 'up' : 'down') : '' ?> ms-1"></i>
                    </a>
                    <a href="?sort=course&order=<?php echo $sort == 'course' && $order == 'asc' ? 'desc' : 'asc' ?>" 
                       class="sort-btn <?php echo $sort == 'course' ? 'active' : '' ?>">
                        Course <i class="fas fa-sort<?php echo $sort == 'course' ? '-' . ($order == 'asc' ? 'up' : 'down') : '' ?> ms-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="student-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Section</th>
                            <th>Course</th>
                            <th>Grades</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM students ORDER BY $sort $order";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['student_id']}</td>
                                    <td>
                                        <a href='edit.php?id={$row['student_id']}' class='student-name'>{$row['name']}</a>
                                    </td>
                                    <td>{$row['section']}</td>
                                    <td>{$row['course']}</td>
                                    <td><strong>{$row['grades']}</strong></td>
                                    <td>
                                        <a href='delete.php?id={$row['student_id']}' class='action-btn delete-btn' title='Delete' onclick='return confirm(\"Are you sure you want to delete this student?\")'>
                                            <i class='fas fa-trash'></i>
                                        </a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-4 text-muted'>No student records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add smooth hover effects
        document.querySelectorAll('.student-table tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
                this.style.transition = 'transform 0.2s ease';
            });
            row.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    </script>
</body>
</html>