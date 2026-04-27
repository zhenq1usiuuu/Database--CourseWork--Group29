<?php 
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$assessor_id = intval($_SESSION['user_id']);
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background-color: white; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        th { background-color: #16325c; color: white !important; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn-menu { display: inline-block; padding: 10px 20px; background-color: #16325c; color: white; text-decoration: none; border-radius: 4px; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>My Grading Records</h2>
    
    <form method="GET">
        <label>Search Student Name:</label>
        <input type="text" name="search" placeholder="Enter name" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Internship ID</th>
                <th>Student Name</th>
                <th>Final Mark</th>
                <th>Comments</th>
                <th>Tasks</th>
                <th>Health</th>
                <th>Knowledge</th> 
                <th>Pres.</th>
                <th>Lang.</th>
                <th>Act.</th>
                <th>Proj.</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT 
                    i.ID AS InternshipID, 
                    s.Name, 
                    r.Final_Mark, 
                    r.Comments, 
                    r.Tasks_Mark, 
                    r.Health_Mark, 
                    r.Knowledge_Mark, 
                    r.Presentation_Mark, 
                    r.Language_Mark, 
                    r.Activities_Mark, 
                    r.Project_Mark, 
                    r.Time_Mark 
                FROM result r
                JOIN internship i ON r.InternshipID = i.ID
                JOIN student s ON i.StudentID = s.ID
                WHERE r.AssessorID = ? AND s.Name LIKE ?
                ORDER BY i.ID DESC";
        
        $stmt = $conn->prepare($sql);
        $likeSearch = "%$search%";
        $stmt->bind_param("is", $assessor_id, $likeSearch);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['InternshipID']}</td>
                        <td>" . htmlspecialchars($row['Name']) . "</td>
                        <td>" . number_format($row['Final_Mark'], 2) . "</td>
                        <td>" . htmlspecialchars($row['Comments']) . "</td>
                        <td>" . number_format($row['Tasks_Mark'], 1) . "</td>
                        <td>" . number_format($row['Health_Mark'], 1) . "</td>
                        <td>" . number_format($row['Knowledge_Mark'], 1) . "</td>
                        <td>" . number_format($row['Presentation_Mark'], 1) . "</td>
                        <td>" . number_format($row['Language_Mark'], 1) . "</td>
                        <td>" . number_format($row['Activities_Mark'], 1) . "</td>
                        <td>" . number_format($row['Project_Mark'], 1) . "</td>
                        <td>" . number_format($row['Time_Mark'], 1) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='12'>No records found.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <br>
    <a href="AssessorMenu.php" class="btn-menu">Back to Menu</a>
</body>
</html>