<?php 
session_start();
include 'connection.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$assessor_id = intval($_SESSION['user_id']);
?>     
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Student</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h1>Select Student</h1>
    <form method="GET" action="select_internship.php"> 
        <label for="student">Student:</label>
        <select id="student" name="student" required> 
        <?php
        $sql = "SELECT DISTINCT s.ID, s.Name, s.Programme 
                FROM student s
                JOIN internship i ON s.ID = i.StudentID
                WHERE i.Uni_AssessorID = ? OR i.Com_AssessorID = ?";
        
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ii", $assessor_id, $assessor_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row['ID']."'>".$row['ID']." - ".htmlspecialchars($row['Name'])." - ".htmlspecialchars($row['Programme'])."</option>";
                }
            } else {
                echo "<option value=''>No assigned students found</option>";
            }
            $stmt->close();
        }
        ?>
        </select>
        <br><br>
        <button type="submit">Next Step</button>
        <br><br>
        <a href="AssessorMenu.php" style="text-decoration: none; color: #666;">Back to Menu</a>
    </form>
</body>
</html>