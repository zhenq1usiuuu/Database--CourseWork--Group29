<?php
include 'connection.php';

$sql = "SELECT 
            i.ID,
            s.Name AS student_name,
            s.Programme,
            u1.Name AS uni_assessor_name,
            u2.Name AS comp_assessor_name,
            i.Company,
            i.StartDate,
            i.EndDate,
            i.Final_Average_Mark
        FROM internship i
        LEFT JOIN student s ON i.StudentID = s.ID
        LEFT JOIN User u1 ON i.Uni_AssessorID = u1.ID
        LEFT JOIN User u2 ON i.Com_AssessorID = u2.ID
        ORDER BY i.ID DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Internship Management</title>
    <style>
        .internship-page { padding: 30px; min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .internship-page h2 { text-align: center; color: #16325c; font-size: 32px; font-weight: bold; margin-bottom: 35px; }
        .internship-table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .internship-table th, .internship-table td { border: 1px solid #eee; padding: 15px; text-align: left; }
        .internship-table th { background-color: #f8f9fa; color: #16325c; font-weight: 600; }
        .id-link { color: #3498db; text-decoration: underline; font-weight: bold; }
        .btn-back { display: inline-block; padding: 10px 20px; background-color: #16325c; color: white; text-decoration: none; border-radius: 4px; margin-top: 20px; }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="internship-page">
    <h2>Internship Management</h2>
     <div class="internship-action-bar">
        <a class="internship-btn" href="SearchInternship.php">Search Internship</a>
        <a class="internship-btn btn-add" href="internship_add.php">Add New Internship</a>
    </div>
    <table class="internship-table">
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Programme</th>
            <th>Uni Assessor</th>
            <th>Comp Assessor</th>
            <th>Company</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Final Mark</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td>
                <?php if ($row['Final_Average_Mark'] > 0): ?>
                    <a class="id-link" href="view_details.php?id=<?php echo $row['ID']; ?>"><?php echo $row['ID']; ?></a>
                <?php else: ?>
                    <?php echo $row['ID']; ?>
                <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo htmlspecialchars($row['Programme']); ?></td>
            <td><?php echo htmlspecialchars($row['uni_assessor_name']); ?></td>
            <td><?php echo htmlspecialchars($row['comp_assessor_name']); ?></td>
            <td><?php echo htmlspecialchars($row['Company']); ?></td>
            <td><?php echo $row['StartDate']; ?></td>
            <td><?php echo $row['EndDate']; ?></td>
            <td><?php echo htmlspecialchars($row['Final_Average_Mark'] > 0 ? number_format($row['Final_Average_Mark'], 2) : 'N/A'); ?></td>
            <td>
                <a href="internship_edit.php?id=<?php echo $row['ID']; ?>">Edit</a> | 
                <a href="internship_delete.php?id=<?php echo $row['ID']; ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="AdminMenu.php" class="btn-back">Back to Menu</a>
</div>
</body>
</html>