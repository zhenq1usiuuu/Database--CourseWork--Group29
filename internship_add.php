<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['StudentID']);
    $uni_assessor_id = intval($_POST['Uni_AssessorID']);
    $com_assessor_id = intval($_POST['Com_AssessorID']);
    $final_average_mark = floatval($_POST['Final_Average_Mark']);
    $company = $_POST['Company'];
    $start_date = $_POST['StartDate'];
    $end_date = $_POST['EndDate'];

    $sql = "INSERT INTO internships
            (StudentID, Uni_AssessorID, Com_AssessorID, Final_Average_Mark, Company, StartDate, EndDate)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "iiidsss",
        $student_id,
        $uni_assessor_id,
        $com_assessor_id,
        $final_average_mark,
        $company,
        $start_date,
        $end_date
    );

    if ($stmt->execute()) {
        header("Location: internship.php");
        exit();
    } else {
        echo "Add failed: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Internship</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        input[type="number"],
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            text-align: center;
            display: block;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add Internship Record</h2>

    <form method="POST">
        <label for="StudentID">Student ID:</label>
        <input type="number" name="StudentID" required>

        <label for="Uni_AssessorID">University Assessor ID:</label>
        <input type="number" name="Uni_AssessorID" required>

        <label for="Com_AssessorID">Company Assessor ID:</label>
        <input type="number" name="Com_AssessorID" required>

        <label for="Final_Average_Mark">Final Average Mark:</label>
        <input type="number" step="0.01" name="Final_Average_Mark" required>

        <label for="Company">Company:</label>
        <input type="text" name="Company" required>

        <label for="StartDate">Start Date:</label>
        <input type="date" name="StartDate" required>

        <label for="EndDate">End Date:</label>
        <input type="date" name="EndDate" required>

        <button type="submit">Add</button>
    </form>

    <p><a href="internship.php">Back to List</a></p>
</div>

</body>
</html>