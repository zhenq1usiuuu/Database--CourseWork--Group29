<?php
session_start();
include 'connection.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $role = $_POST['Role'];

    if (!empty($username) && !empty($password) && !empty($role)) {
        correctLogin($username, $password, $role);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body> 
    <h1>E-Internship</h1>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="Username">Username:</label>
        <input type="text" name="Username" id="Username" placeholder="Enter your username" required><br><br>
        
        <label for="Password">Password:</label>
        <input type="password" name="Password" id="Password" placeholder="Enter your password" required><br><br>
        
        <label for="Role">Role:</label>
        <select name="Role" id="Role" required>
            <option value="Admin">Admin</option>
            <option value="University Assessor">University Assessor</option>
            <option value="Company Assessor">Company Assessor</option>
        </select><br><br>
        
        <input type="submit" name="submit" value="Login">
    </form>
    <p>Don't have an Admin account? <a href="Signup.php">Signup For Admin</a>.</p>
    <p>Need an Assessor account? <a href="Request.php">Request Account For Assessors</a>.</p>
</body>
</html>