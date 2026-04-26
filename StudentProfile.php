<?php
session_start();
include 'connection.php';
include 'functions.php';
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    
    <div class="table-card">
        <div class="card-header">
            <h2>List of Students</h2>
            <a href="SearchStudents.php" class="btn btn-primary">Search Students</a>
            <a href="add_student.php" class="btn btn-primary">Add New Student</a>
        </div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Programme</th>
                    <th>Actions</th> </tr>
            </thead>
            <tbody>
            <?php
            $result = getStudents();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Programme']) . "</td>";
                    echo "<td class='action-links'>
                            <a href='update_student.php?id=" . htmlspecialchars($row['ID']) . "' class='btn-small btn-edit'>Update</a>
                            <a href='delete_student.php?id=" . htmlspecialchars($row['ID']) . "' class='btn-small btn-danger' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No students found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
        
        <div class="card-footer">
            <a href="AdminMenu.php" class="btn-outline">Go Back</a>
        </div>
    </div>
</body>
</html>