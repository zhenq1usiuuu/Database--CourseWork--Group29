<?php
include 'connection.php';
include 'functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id = $_POST['ID'];
$name = $_POST['name'];
$programme = $_POST['programme'];
// Validate input
if (empty($name) || empty($programme)) {
echo "Name and programme are required.";
} else {
$result = updateStudent($id, $name, $programme);
if ($result) {
echo "Student updated successfully.";
header("Refresh:3; url=StudentProfile.php"); // Redirect after 3 seconds
} else {
echo "Failed to update student: " . $conn->error;
}
}
} else {
$id = $_GET['id'];
$result = getStudentById($id);
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$name = $row['Name'];
$programme = $row['Programme'];
} else {
echo "Student not found.";
exit;
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Update Student</title>
</head>
<body>
<h2>Update Student</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="ID" value="<?php echo $id; ?>">
<label for="name">Name:</label>
<input type="text" name="name" id="name" value="<?php echo $name; ?>" required><br><br>
<label for="programme">Programme:</label>
<input type="text" name="programme" id="programme" value="<?php echo $programme; ?>" required><br><br>
<input type="submit" name="submit" value="Update Student">
</form>
</body>
</html>