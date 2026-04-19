<!DOCTYPE html>
<html>
<head>
<title>Add Assessor</title>
<script src="validation.js"></script>
</head>
<body>
<h2>Add Assessor</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateAssessor(this);">
<label for="name">Name:</label>
<input type="text" name="name" id="name"  placeholder="Enter Assessor's Name" required><br><br>
<label for="username" >Username:</label>
<input type="text" name="username" id="username"  placeholder="At least 5 characters"required><br><br>
<label for="password" >Password:</label>
<input type="password" name="password" id="password" placeholder="At least 6 characters" required><br><br>
<label for="role">Role:</label>
<select name="role" id="role" required>
    <option value="University Assessor">University Assessor</option>
    <option value="Company Assessor">Company Assessor</option>
</select><br><br>
<input type="submit" name="submit" value="Add Assessor">
</form><br><br>
 <a href="AssessorManagement.php">Go Back</a>
</body>
</html>

<?php
include 'connection.php';
include 'functions.php'; // Assuming your CRUD functions are in a separate file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
// Validate input
if (empty($name) || empty($username) || empty($password) || empty($role)) {
    echo "All fields are required.";
} else {
$result = createAdmin($name, $username, $password, $role);
if ($result) {
echo "Assessor added successfully.";
} else {
echo "Failed to add assessor: " . $conn->error;
}
}
}