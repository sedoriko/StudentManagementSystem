<?php
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 50%, #388e3c 100%);">
    <div class="container-fluid">
        <a class="navbar-brand" href="student_dashboard.php">
            <img src="background/logo.jpg" alt="Logo" height="30" class="d-inline-block align-top me-2">
            <span style="font-family: 'Barlow', sans-serif; font-weight: 600;">STUDENT PORTAL</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="student_edit_profile.php" title="Edit Profile">
                        <i class="fas fa-user-circle fa-lg" style="color: #c8e6c9;"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" title="Logout">
                        <i class="fas fa-sign-out-alt fa-lg" style="color: #c8e6c9;"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Include Font Awesome and Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500;600&display=swap" rel="stylesheet">