<?php
include 'connection.php';
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessor Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    
    <div class="table-card">
        <div class="card-header">
            <h2>List of Assessors</h2>
            <a href="add_assessor.php" class="btn-primary">Add New Assessor</a>
        </div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th>Assessor ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $result = getAssessors();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Password']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Role']) . "</td>";
                    echo "<td class='action-links'>
                            <a href='update_assessor.php?id=" . htmlspecialchars($row['ID']) . "' class='btn-small btn-edit'>Update</a>
                            <a href='delete_assessor.php?id=" . htmlspecialchars($row['ID']) . "' class='btn-small btn-danger' onclick='return confirm(\"Are you sure you want to delete this assessor?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No assessors found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
        
        <div class="card-footer">
            <a href="AdminMenu.php" class="btn-outline">Back to Admin Menu</a>
        </div>
    </div>
</body>
</html>