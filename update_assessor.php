<?php
include 'connection.php';
include 'functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id = $_POST['ID'];
$name = $_POST['name'];
$Username = $_POST['username'];
$Password = $_POST['password'];
$Role = $_POST['role'];
// Validate input
if (empty($name) || empty($Username)) {
echo "Name and username are required.";
} else {
$result = updateAssessor($id, $name, $Username, $Password, $Role);
if ($result) {
echo "Assessor updated successfully.";
header("Refresh:3; url=AssessorManagement.php"); // Redirect after 3 seconds
} else {
echo "Failed to update assessor: " . $conn->error;
}
}
} else {
$id = $_GET['id'];
$result = getAssessorsById($id);
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$name = $row['Name'];
$username = $row['Username'];
$password = $row['Password'];
$role = $row['Role'];
} else {
echo "Assessor not found.";
exit;
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Update Assessor</title>
</head>
<body>
<h2>Update Assessor</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="ID" value="<?php echo $id; ?>">
<label for="name">Name:</label>
<input type="text" name="name" id="name" value="<?php echo $name; ?>" required><br><br>
<label for="username">Username:</label>
<input type="text" name="username" id="username" value="<?php echo $username; ?>" required><br><br>
<label for="password">Password:</label>
<input type="password" name="password" id="password" value="<?php echo $password; ?>" required><br><br>
<label for="role">Role:</label>
<select name="role" id="role" value="<?php echo $role; ?>" required>
    <option value="University Assessor" <?php if ($role === 'University Assessor') echo 'selected'; ?>>University Assessor</option>
    <option value="Company Assessor" <?php if ($role === 'Company Assessor') echo 'selected'; ?>>Company Assessor</option>
</select><br><br>
<input type="submit" name="submit" value="Update Assessor">
</form>
<a href="AssessorManagement.php">Go Back</a>
</body>
</html>