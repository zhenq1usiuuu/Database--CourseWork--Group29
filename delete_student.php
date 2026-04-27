<?php
session_start();
include 'connection.php';
include 'functions.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: Login.php");
    exit();
}

$message = "";
$name = "";
$programme = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $result = deleteStudent($id);
    if ($result) {
        $message = "<div class='message success'>Student deleted successfully. Redirecting...</div>";
        header("Refresh:2; url=StudentProfile.php"); 
    } else {
        $message = "<div class='message error'>Failed to delete student: " . $conn->error . "</div>";
    }
} else {
    $id = $_GET['id'];
    $result = getStudentByID($id);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['Name'];
        $programme = $row['Programme'];
    } else {
        echo "<div class='message error'>Student not found.</div>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    <h2>Delete Student</h2>
    
    <?php if(!empty($message)): ?>
        <?php echo $message; ?>
    <?php else: ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <p class="warning-text">Are you sure you want to delete the following student?</p>
            
            <div class="info-group">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Programme:</strong> <?php echo htmlspecialchars($programme); ?></p>
            </div>
            
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <input type="submit" name="submit" value="Confirm Delete" class="btn-delete-confirm">
        </form>
    <?php endif; ?>

    <div style="margin-top: 25px;">
        <a href="StudentProfile.php" class="btn-outline">Cancel / Go Back</a>
    </div>
</body>
</html>