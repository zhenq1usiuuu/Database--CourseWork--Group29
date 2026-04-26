<?php
session_start();
include 'connection.php';
include 'functions.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: Login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: Internship.php");
    exit();
}

$id = intval($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM internship WHERE ID = ?";
    $params = [$id];

    if (executePreparedStatement($sql, $params)) {
        echo "<script>
                alert('Internship record deleted successfully.');
                window.location.href = 'Internship.php';
              </script>";
        exit();
    } else {
        $error_message = "Error: Could not delete the record.";
    }
}

$sql_fetch = "SELECT 
                i.ID, 
                s.Name AS student_name, 
                i.Company, 
                i.StartDate, 
                i.EndDate 
              FROM internship i
              LEFT JOIN student s ON i.StudentID = s.ID
              WHERE i.ID = ?";
$result = executePreparedStatement($sql_fetch, [$id]);
$data = $result->fetch_assoc();

if (!$data) {
    die("Record not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Internship</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; padding: 40px; }
        .delete-container {
            background-color: #fff;
            max-width: 500px;
            margin: auto;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 { color: #e74c3c; margin-bottom: 20px; }
        .record-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            text-align: left;
            margin-bottom: 30px;
            border-left: 5px solid #e74c3c;
        }
        .record-details p { margin: 10px 0; color: #34495e; }
        .warning-text { color: #7f8c8d; margin-bottom: 25px; font-size: 15px; }
        .btn-delete {
            background-color: #e74c3c;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }
        .btn-delete:hover { background-color: #c0392b; }
        .cancel-link {
            display: block;
            margin-top: 20px;
            color: #95a5a6;
            text-decoration: none;
            font-size: 14px;
        }
        .cancel-link:hover { color: #7f8c8d; text-decoration: underline; }
    </style>
</head>
<body>

<div class="delete-container">
    <h2>Confirm Deletion</h2>
    <p class="warning-text">Are you sure you want to permanently delete this internship record? This action cannot be undone.</p>

    <div class="record-details">
        <p><strong>Internship ID:</strong> <?php echo $data['ID']; ?></p>
        <p><strong>Student Name:</strong> <?php echo htmlspecialchars($data['student_name']); ?></p>
        <p><strong>Company:</strong> <?php echo htmlspecialchars($data['Company']); ?></p>
        <p><strong>Duration:</strong> <?php echo $data['StartDate']; ?> to <?php echo $data['EndDate']; ?></p>
    </div>

    <form method="POST">
        <button type="submit" class="btn-delete">Delete Record</button>
        <a href="Internship.php" class="cancel-link">Cancel and Go Back</a>
    </form>
</div>

</body>
</html>