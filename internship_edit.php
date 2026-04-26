<?php
include 'connection.php';

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['StudentID']);
    $uni_assessor_id = intval($_POST['Uni_AssessorID']);
    $com_assessor_id = intval($_POST['Com_AssessorID']);
    $final_average_mark = $_POST['Final_Average_Mark'];
    $company = $_POST['Company'];
    $start_date = $_POST['StartDate'];
    $end_date = $_POST['EndDate'];

    $sql = "UPDATE internships
            SET StudentID = ?,
                Uni_AssessorID = ?,
                Com_AssessorID = ?,
                Final_Average_Mark = ?,
                Company = ?,
                StartDate = ?,
                EndDate = ?
            WHERE ID = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "iiidsssi",
        $student_id,
        $uni_assessor_id,
        $com_assessor_id,
        $final_average_mark,
        $company,
        $start_date,
        $end_date,
        $id
    );

    if ($stmt->execute()) {
        header("Location: /CWinternship/internship.php");
        exit();
    } else {
        echo "Update failed: " . $stmt->error;
    }
}

$sql = "SELECT * FROM internships WHERE ID = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Record not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Internship</title>
</head>
<body>
<h2>Edit Internship Record</h2>

<form method="POST">
    <label>Student ID:</label><br>
    <input type="number" name="StudentID" value="<?php echo htmlspecialchars($data['StudentID']); ?>" required><br><br>

    <label>University Assessor ID:</label><br>
    <input type="number" name="Uni_AssessorID" value="<?php echo htmlspecialchars($data['Uni_AssessorID']); ?>" required><br><br>

    <label>Company Assessor ID:</label><br>
    <input type="number" name="Com_AssessorID" value="<?php echo htmlspecialchars($data['Com_AssessorID']); ?>" required><br><br>

    <label>Final Average Mark:</label><br>
    <input type="number" step="0.01" name="Final_Average_Mark" value="<?php echo htmlspecialchars($data['Final_Average_Mark']); ?>" required><br><br>

    <label>Company:</label><br>
    <input type="text" name="Company" value="<?php echo htmlspecialchars($data['Company']); ?>" required><br><br>

    <label>Start Date:</label><br>
    <input type="date" name="StartDate" value="<?php echo htmlspecialchars($data['StartDate']); ?>" required><br><br>

    <label>End Date:</label><br>
    <input type="date" name="EndDate" value="<?php echo htmlspecialchars($data['EndDate']); ?>" required><br><br>

    <button type="submit">Update</button>
</form>

<a href="/CWinternship/internship.php">Back to List</a>
</body>
</html>