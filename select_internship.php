<?php 
session_start();
include 'connection.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

if (!isset($_GET['student'])) {
    header("Location: select_student.php");
    exit();
}

$assessor_id = intval($_SESSION['user_id']);
$student_id = intval($_GET['student']);

$student_query = "SELECT Name FROM student WHERE ID = ?";
$stmt_student = $conn->prepare($student_query);
$stmt_student->bind_param("i", $student_id);
$stmt_student->execute();
$student_result = $stmt_student->get_result();

$student_name = "Unknown Student";
if ($row = $student_result->fetch_assoc()) {
    $student_name = $row['Name'];
}
$stmt_student->close();

$sql = "SELECT * FROM internship WHERE StudentID = ? AND (Uni_AssessorID = ? OR Com_AssessorID = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $student_id, $assessor_id, $assessor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Internship</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h1>Select Internship for <?php echo htmlspecialchars($student_name); ?></h1>
    
    <form method="GET" action="enter_result.php">
        <input type="hidden" name="student" value="<?php echo $student_id; ?>">
        
        <label for="internship_id">Select Internship Project:</label>
        <select id="internship_id" name="internship_id" required>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $display_text = htmlspecialchars($row['Company']) . " (" . $row['StartDate'] . " to " . $row['EndDate'] . ")";
                    echo "<option value='".$row['ID']."'>".$display_text."</option>";
                }
            } else {
                echo "<option value=''>No assigned internship records found</option>";
            }
            ?>
        </select>
        
        <br><br>
        <button type="submit" <?php if($result->num_rows == 0) echo 'disabled'; ?>>Proceed to Grading</button>
        <br><br>
        <a href="select_student.php" style="text-decoration: none; color: #666;">Back to Student Selection</a>
    </form>
</body>
</html>
<?php 
if (isset($stmt)) {
    $stmt->close();
}
?>