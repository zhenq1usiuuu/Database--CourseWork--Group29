<?php
session_start();
include 'connection.php';
include 'functions.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: Login.php");
    exit();
}

$error_message = "";
$students = getStudents();
$uni_assessors = executePreparedStatement("SELECT ID, Name FROM User WHERE Role = 'University Assessor'", []);
$comp_assessors = executePreparedStatement("SELECT ID, Name FROM User WHERE Role = 'Company Assessor'", []);

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
        $sql = "INSERT INTO internship
                (StudentID, Uni_AssessorID, Com_AssessorID, Company, StartDate, EndDate) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $params = [$student_id, $uni_assessor_id, $com_assessor_id, $company, $start_date, $end_date];

        if (executePreparedStatement($sql, $params)) {
            header("Location: Internship.php");
            exit();
        } else {
            $error_message = "Error: Could not save the internship record.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Internship</title>
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
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover { background-color: #27ae60; }
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
    <h2>Assign New Internship</h2>

    <?php if ($error_message): ?>
        <div class="error-banner"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="internship_add.php" onsubmit="return validateDates()">
        <label for="StudentID">Student Name:</label>
        <select name="StudentID" required>
            <option value="">-- Select Student --</option>
            <?php while($row = $students->fetch_assoc()): ?>
                <option value="<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['Name']); ?></option>
            <?php endwhile; ?>
        </select>

        <label for="Uni_AssessorID">University Assessor:</label>
        <select name="Uni_AssessorID" required>
            <option value="">-- Select University Assessor --</option>
            <?php while($row = $uni_assessors->fetch_assoc()): ?>
                <option value="<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['Name']); ?></option>
            <?php endwhile; ?>
        </select>

        <label for="Com_AssessorID">Company Assessor:</label>
        <select name="Com_AssessorID" required>
            <option value="">-- Select Company Assessor --</option>
            <?php while($row = $comp_assessors->fetch_assoc()): ?>
                <option value="<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['Name']); ?></option>
            <?php endwhile; ?>
        </select>

        <label for="Company">Target Company:</label>
        <input type="text" name="Company" placeholder="Enter company name" required>

        <label for="StartDate">Internship Start Date:</label>
        <input type="date" id="StartDate" name="StartDate" required>

        <label for="EndDate">Internship End Date:</label>
        <input type="date" id="EndDate" name="EndDate" required>

        <button type="submit">Confirm Assignment</button>
        <a href="internship.php" class="cancel-link">Cancel and Return</a>
    </form>
</div>

</body>
</html>