<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Account For Assessors</title>
    <script src="validation.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <body>
    <h1>E-Internship</h1>
    <h2>Request Account For Assessors</h2>
    
    <form method="post" onsubmit="return validateAdmin(this)">
        <label for="Name">Name:</label>
        <input type="text" name="Name" id="Name" placeholder="Please Enter Your Name" required>

        <label for="Username">Username:</label>
        <input type="text" name="Username" id="Username" placeholder="At least 5 characters" required>

        <label for="Password">Password:</label>
        <input type="password" name="Password" id="Password" placeholder="At least 6 characters" required>

        <label for="Role">Role:</label>
        <select name="Role" id="Role" required>
            <option value="University Assessor">University Assessor</option>
            <option value="Company Assessor">Company Assessor</option>
        </select>

        <input type="submit" name="submit" value="Request Account">
    </form>
    
    <p>Already have an Assessor account? <a href="Login.php">Login here.</a></p>
    <p>Need signup for Admin account? <a href="Signup.php">Signup here.</a>.</p>

    </body>
</body>
</html>

<?php
include 'connection.php';
include 'functions.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $role = "Request: " . $_POST['Role'];
    
    // Validate input
    if (empty($name) || empty($username) || empty($password) || empty($role)) {
        echo "<div class='message error'>All fields are required.</div>";
    } else {
        $result = createUser($name, $username, $password, $role);
        if ($result) {
            echo "<div class='message success'>Account request submitted successfully.Please wait for approval.</div>";
        } else {
            echo "<div class='message error'>Failed to submit account request: " . $conn->error . "</div>";
        }
    }
}
?>
