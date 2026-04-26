<?php
session_start();
include 'connection.php';
include 'functions.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: Login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['ID'];
    $name = $_POST['name'];
    $programme = $_POST['programme'];
    
    if (empty($name) || empty($programme)) {
        $message = "<div class='message error'>Name and programme are required.</div>";
    } else {
        $result = updateStudent($id, $name, $programme);
        if ($result) {
            $message = "<div class='message success'>Student updated successfully. Redirecting...</div>";
            header("Refresh:3; url=StudentProfile.php");
        } else {
            $message = "<div class='message error'>Failed to update student: " . $conn->error . "</div>";
        }
    }
} else {
    $id = $_GET['id'];
    $result = getStudentById($id);
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
    <title>Update Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    <h2>Update Student</h2>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="ID" value="<?php echo htmlspecialchars($id); ?>">
        
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
        
        <label for="programme">Programme:</label>
        <input type="text" name="programme" id="programme" value="<?php echo htmlspecialchars($programme); ?>" required>
        
        <input type="submit" name="submit" value="Update Student">
    </form>

    <?php if(!empty($message)) echo $message; ?>

    <div style="margin-top: 25px;">
        <a href="StudentProfile.php" class="btn-outline">Go Back</a>
    </div>
</body>
</html>