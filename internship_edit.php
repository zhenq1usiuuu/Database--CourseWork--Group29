<?php
session_start();
include 'connection.php';
include 'functions.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: Login.php");
    exit();
}

$error_message = "";
if (!isset($_GET['id'])) {
    header("Location: Internship.php");
    exit();
}

$id = intval($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['StudentID']);
    $uni_assessor_id = intval($_POST['Uni_AssessorID']);
    $com_assessor_id = intval($_POST['Com_AssessorID']);
    $company = $_POST['Company'];
    $start_date = $_POST['StartDate'];
    $end_date = $_POST['EndDate'];

    if (strtotime($start_date) > strtotime($end_date)) {
        $error_message = "Error: Internship Start Date cannot be later than End Date.";
    } else {
        $sql = "UPDATE internship 
                SET StudentID = ?, Uni_AssessorID = ?, Com_AssessorID = ?, Company = ?, StartDate = ?, EndDate = ? 
                WHERE ID = ?";

        $params = [$student_id, $uni_assessor_id, $com_assessor_id, $company, $start_date, $end_date, $id];

        if (executePreparedStatement($sql, $params)) {
            header("Location: Internship.php");
            exit();
        } else {
            $error_message = "Error: Could not update the internship record.";
        }
    }
}

$current_data = executePreparedStatement("SELECT * FROM internship WHERE ID = ?", [$id])->fetch_assoc();
if (!$current_data) {
    die("Record not found.");
}

$students = getStudents();
$uni_assessors = executePreparedStatement("SELECT ID, Name FROM User WHERE Role = 'University Assessor'", []);
$comp_assessors = executePreparedStatement("SELECT ID, Name FROM User WHERE Role = 'Company Assessor'", []);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Internship</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; padding: 40px; }
        .form-container {
            background-color: #fff;
            max-width: 600px;
            margin: auto;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 25px; }
        label { display: block; margin-top: 15px; font-weight: 600; color: #34495e; }
        select, input {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #dcdfe6;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .error-banner {
            background-color: #fde2e2;
            color: #f56c6c;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            border: 1px solid #fbc4c4;
        }
        button {
            width: 100%;
            padding: 14px;
            margin-top: 30px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover { background-color: #2980b9; }
        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #95a5a6;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
    <script>
        function validateDates() {
            var start = new Date(document.getElementById('StartDate').value);
            var end = new Date(document.getElementById('EndDate').value);
            
            if (start > end) {
                alert("The Start Date must be before the End Date.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<div class="form-container">
    <h2>Edit Internship Record</h2>

    <?php if ($error_message): ?>
        <div class="error-banner"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" onsubmit="return validateDates()">
        <label for="StudentID">Student Name:</label>
        <select name="StudentID" required>
            <?php while($row = $students->fetch_assoc()): ?>
                <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $current_data['StudentID']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($row['Name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="Uni_AssessorID">University Assessor:</label>
        <select name="Uni_AssessorID" required>
            <?php while($row = $uni_assessors->fetch_assoc()): ?>
                <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $current_data['Uni_AssessorID']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($row['Name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="Com_AssessorID">Company Assessor:</label>
        <select name="Com_AssessorID" required>
            <?php while($row = $comp_assessors->fetch_assoc()): ?>
                <option value="<?php echo $row['ID']; ?>" <?php if($row['ID'] == $current_data['Com_AssessorID']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($row['Name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="Company">Target Company:</label>
        <input type="text" name="Company" value="<?php echo htmlspecialchars($current_data['Company']); ?>" required>

        <label for="StartDate">Internship Start Date:</label>
        <input type="date" id="StartDate" name="StartDate" value="<?php echo $current_data['StartDate']; ?>" required>

        <label for="EndDate">Internship End Date:</label>
        <input type="date" id="EndDate" name="EndDate" value="<?php echo $current_data['EndDate']; ?>" required>

        <button type="submit">Update Record</button>
        <a href="Internship.php" class="cancel-link">Cancel and Return</a>
    </form>
</div>

</body>
</html>