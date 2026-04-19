<?php
include 'connection.php';
include 'functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id = $_POST['id'];
$result = deleteAssessor($id);
if ($result) {echo "Assessor deleted successfully.";
header("Location:AssessorManagement.php"); 
} else {
echo "Failed to delete assessor: " . $conn->error;
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
<title>Delete Assessor</title>
</head>
<body>
<h2>Delete Assessor</h2>
<p>Are you sure you want to delete the following assessor?</p>
<p><strong>Name:</strong> <?php echo $name; ?></p>
<p><strong>Username:</strong> <?php echo $username; ?></p>
<p><strong>Password:</strong> <?php echo $password; ?></p>
<p><strong>Role:</strong> <?php echo $role; ?></p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="submit" name="submit" value="Delete Assessor">
</form>
</body>
</html>