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
    $name = $_POST['name'];
    $programme = $_POST['programme'];
    
    if (empty($name) || empty($programme)) {
        $message = "<div class='message error'>Name and programme are required.</div>";
    } else {
        $result = createStudent($name, $programme);
        if ($result) {
            $message = "<div class='message success'>Student added successfully.</div>";
        } else {
            $message = "<div class='message error'>Failed to add student: " . $conn->error . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    <h2>Add Student</h2>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" placeholder="Student's Name" required>
        
        <label for="programme">Programme:</label>
        <input type="text" name="programme" id="programme" placeholder="Student's Programme" required>
        
        <input type="submit" name="submit" value="Add Student">
    </form>

    <?php if(!empty($message)) echo $message; ?>

    <div style="margin-top: 25px;">
        <a href="StudentProfile.php" class="btn-outline">Go Back</a>
    </div>
</body>
</html>