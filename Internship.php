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
        .internship-action-bar { text-align: center; margin-bottom: 30px; }
        
        .internship-btn {
            padding: 12px 24px;
            background-color: #16325c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 15px;
            margin: 0 10px;
            font-weight: bold;
            display: inline-block;
            transition: background 0.3s;
        }
        .internship-btn:hover { background-color: #0d2343; }
        .btn-add { background-color: #2ecc71; }
        .btn-add:hover { background-color: #27ae60; }

        /* Beautified Go Back Button */
        .btn-back {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #f8f9fa;
            color: #16325c;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid #16325c;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #16325c;
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateX(-5px); /* 微小的左移动画，暗示“返回” */
        }

        .internship-table { width: 100%; border-collapse: collapse; margin-top: 20px; background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .internship-table th, .internship-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .internship-table th { background-color: #f8f9fa; color: #333; font-weight: bold; }
        .internship-edit { color: #16325c; text-decoration: none; font-weight: bold; margin-right: 10px; }
        .internship-delete { color: #e74c3c; text-decoration: none; font-weight: bold; }
        
        .footer-actions {
            text-align: center;
            margin-top: 20px;
        }
    </style>
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
            <td><?php echo $row['ID']; ?></td>
            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo htmlspecialchars($row['Programme']); ?></td>
            <td><?php echo htmlspecialchars($row['uni_assessor_name']); ?></td>
            <td><?php echo htmlspecialchars($row['comp_assessor_name']); ?></td>
            <td><?php echo htmlspecialchars($row['Company']); ?></td>
            <td><?php echo $row['StartDate']; ?></td>
            <td><?php echo $row['EndDate']; ?></td>
            <td><?php echo htmlspecialchars($row['Final_Average_Mark'] ?? 'N/A'); ?></td>
            <td>
                <a class="internship-edit" href="internship_edit.php?id=<?php echo $row['ID']; ?>">Edit</a>
                <a class="internship-delete" href="internship_delete.php?id=<?php echo $row['ID']; ?>" onclick="return confirm('Delete this record?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="footer-actions">
        <a href="AdminMenu.php" class="btn-back">← Back to Admin Menu</a>
    </div>
</div>
</body>
</html>