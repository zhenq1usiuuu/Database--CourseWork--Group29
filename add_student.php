<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
</head>
<body>
<h2>Add Student</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<label for="name">Name:</label>
<input type="text" name="name" id="name" placeholder="Student's Name" required><br><br>
<label for="programme">Programme:</label>
<input type="text" name="programme" id="programme" placeholder="Student's Programme" required><br><br>
<input type="submit" name="submit" value="Add Student">
</form><br><br>
 <a href="StudentProfile.php">Go Back</a>
</body>
</html>

<?php
include 'connection.php';
include 'functions.php'; // Assuming your CRUD functions are in a separate file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$name = $_POST['name'];
$programme = $_POST['programme'];
// Validate input
if (empty($name) || empty($programme)) {
    echo "Name and programme are required.";
} else {
$result = createStudent($name, $programme);
if ($result) {
echo "Student added successfully.";
} else {
echo "Failed to add student: " . $conn->error;
}
}
}