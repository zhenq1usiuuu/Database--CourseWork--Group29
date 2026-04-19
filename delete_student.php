<?php
include 'connection.php';
include 'functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id = $_POST['id'];
$result = deleteStudent($id);
if ($result) {echo "Student deleted successfully.";
header("Location:StudentProfile.php"); 
} else {
echo "Failed to delete student: " . $conn->error;
}
} else {
$id = $_GET['id'];
$result = getStudentByID($id);
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
<title>Delete Student</title>
</head>
<body>
<h2>Delete Student</h2>
<p>Are you sure you want to delete the following student?</p>
<p><strong>Name:</strong> <?php echo $name; ?></p>
<p><strong>Programme:</strong> <?php echo $programme; ?></p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="submit" name="submit" value="Delete Student">
</form>
</body>
</html>