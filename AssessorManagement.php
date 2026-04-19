<?php
include 'connection.php';
include 'functions.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Assessor Management</title>
</head>
<body>
<h2>List of Assessors</h2>
<table>
<tr>
<th>Assessor ID</th>
<th>Name</th>
<th>Username</th>
<th>Password</th>
<th>Role</th>
<th><a href="add_assessor.php">Add New Assessor</a></th>
</tr>
<?php
$result = getAssessors();
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
echo "<tr>";
echo "<td>" . $row['ID'] . "</td>";
echo "<td>" . $row['Name'] . "</td>";
echo "<td>" . $row['Username'] . "</td>";
echo "<td>" . $row['Password'] . "</td>";
echo "<td>" . $row['Role'] . "</td>";
echo "<td>
        <a href='update_assessor.php?id=" . $row['ID'] . "'>Update</a>
        <a href='delete_assessor.php?id=" . $row['ID'] . "' onclick='return confirm(\"Are you sure you want to delete this assessor?\")'>Delete</a>
</td>";
echo "</tr>";
}
} else {
echo "<tr><td colspan='4'>No assessors found.</td></tr>";
}
?>
</table><br><br>
<a href="AdminMenu.php">Back to Admin Menu</a>
</body>
</html>