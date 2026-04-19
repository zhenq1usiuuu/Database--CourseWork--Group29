<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src="validation.js"></script>
</head>
<body>
    <h1>E-Internship</h1>
    <table class="Signup">
        <th colspan="2"><h2>Signup For Admin</h2></th>
        <form method="post" onsubmit="return validateAdmin(self)">
        <tr>
            <td>Name:</td>
            <td><input type="text" name="Name" id="Name" placeholder="Please Enter Your Name" required></td>
        </tr>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="Username" id="Username" placeholder="At least 5 characters" required></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="Password" id="Password" placeholder="At least 6 characters" required></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="submit" value="Signup"></td>
        </tr>
        </form>
    </table><br><br>
    <p>Already have an Admin account? <a href="Login.php">Login here.</a></p>
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
    echo "All fields are required.";
} else {
$result = createAdmin($name, $username, $password, $role);
if ($result) {
echo "Admin added successfully.";
} else {
echo "Failed to add admin: " . $conn->error;
}
}
}
?>