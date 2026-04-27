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
$username = "";
$password = "";
$role = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $result = deleteAssessor($id);
    if ($result) {
        $message = "<div class='message success'>Assessor request refused. Redirecting...</div>";
        header("Refresh:2; url=AssessorManagement.php"); 
    } else {
        $message = "<div class='message error'>Failed to refuse assessor request: " . $conn->error . "</div>";
    }
} else {
    $id = $_GET['id'];
    $result = getAssessorsById($id);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['Name'];
        $username = $row['Username'];
        $password = $row['Password'];
        $role = $row['Role'];
    } else {
        echo "<div class='message error'>Assessor not found.</div>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refuse Assessor Request</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    <h2>Refuse Assessor Request</h2>
    
    <?php if(!empty($message)): ?>
        <?php echo $message; ?>
    <?php else: ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <p class="warning-text">Are you sure you want to refuse the following assessor request?</p>
            
            <div class="info-group">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p><strong>Password:</strong> <?php echo htmlspecialchars($password); ?></p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>
            </div>
            
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <input type="submit" name="submit" value="Confirm Refuse" class="btn-delete-confirm">
        </form>
    <?php endif; ?>

    <div style="margin-top: 25px;">
        <a href="AssessorRequests.php" class="btn-outline">Cancel / Go Back</a>
    </div>
</body>
</html>