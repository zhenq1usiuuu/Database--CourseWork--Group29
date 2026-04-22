<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src="validation.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <body>
    <h1>E-Internship</h1>
    <h2>Signup For Admin</h2>
    
    <form method="post" onsubmit="return validateAdmin(this)">
        <label for="Name">Name:</label>
        <input type="text" name="Name" id="Name" placeholder="Please Enter Your Name" required>

        <label for="Username">Username:</label>
        <input type="text" name="Username" id="Username" placeholder="At least 5 characters" required>

        <label for="Password">Password:</label>
        <input type="password" name="Password" id="Password" placeholder="At least 6 characters" required>

        <input type="submit" name="submit" value="Signup">
    </form>
    
    <p>Already have an Admin account? <a href="Login.php">Login here.</a></p>

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
    $role = 'Admin';
    
    // Validate input
    if (empty($name) || empty($username) || empty($password)) {
        echo "<div class='message error'>All fields are required.</div>";
    } else {
        $result = createAdmin($name, $username, $password, $role);
        if ($result) {
            echo "<div class='message success'>Admin added successfully.</div>";
        } else {
            echo "<div class='message error'>Failed to add admin: " . $conn->error . "</div>";
        }
    }
}
?>