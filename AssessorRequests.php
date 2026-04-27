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
    <title>Assessor Requests</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    
    <div class="table-card">
        <div class="card-header">
            <h2>List of Requesting Assessors</h2>
            
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
            $result = getAssessorRequests();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Password']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Role']) . "</td>";
                    echo "<td class='action-links'>
                            <a href='accept_assessor.php?id=" . htmlspecialchars($row['ID']) . "' class='btn-small btn-edit'>Accept</a>
                            <a href='refuse_assessor.php?id=" . htmlspecialchars($row['ID']) . "' class='btn-small btn-danger' onclick='return confirm(\"Are you sure you want to refuse this assessor request?\")'>Refuse</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No assessor requests found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
        
        <div class="card-footer">
            <a href="AssessorManagement.php" class="btn-outline">Go Back</a>
        </div>
    </div>
</body>
</html>