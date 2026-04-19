<?php
include 'connection.php';
include 'functions.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Student Profile</title>
</head>
<body>
<h2>List of Students</h2>
<table>
<tr>
<th>Student ID</th>
<th>Name</th>
<th>Programme</th>
<th><a href="add_student.php">Add New Student</a></th>
</tr>
<?php
$result = getStudents();
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
echo "<tr>";
echo "<td>" . $row['ID'] . "</td>";
echo "<td>" . $row['Name'] . "</td>";
echo "<td>" . $row['Programme'] . "</td>";
echo "<td>
        <a href='update_student.php?id=" . $row['ID'] . "'>Update</a>
        <a href='delete_student.php?id=" . $row['ID'] . "' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
</td>";
echo "</tr>";
}
} else {
echo "<tr><td colspan='4'>No students found.</td></tr>";
}
?>
</table>
<a href="AdminMenu.php">Go Back</a>
</body>
</html>