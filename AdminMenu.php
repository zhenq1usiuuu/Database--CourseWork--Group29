
<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    <h2>Admin Menu</h2>
    
    <div class="menu-card">
        <nav class="menu-links">
            <a href="StudentProfile.php" class="menu-btn">Student Profile</a>
            <a href="AssessorManagement.php" class="menu-btn">Assessor Management</a>
            <a href="Internship.php" class="menu-btn">Internship</a>
        </nav>
        
        <div class="logout-container">
            <a href="logout.php" class="logout-btn" onclick='return confirm("Are you sure you want to logout?");'>Logout</a>
        </div>
    </div>
</body>
</html>