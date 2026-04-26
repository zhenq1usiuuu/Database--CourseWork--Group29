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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($name) || empty($username) || empty($password) || empty($role)) {
        $message = "<div class='message error'>All fields are required.</div>";
    } else {
        $result = createUser($name, $username, $password, $role);
        if ($result) {
            $message = "<div class='message success'>Assessor added successfully.</div>";
        } else {
            $message = "<div class='message error'>Failed to add assessor: " . $conn->error . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Assessor</title>
    <link rel="stylesheet" href="style.css">
    <script src="validation.js"></script>
</head>
<body>
    <h1>E-Internship</h1>
    <h2>Add Assessor</h2>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validateAssessor(this);">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter Assessor's Name" required>
        
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="At least 5 characters" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="At least 6 characters" required>
        
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="University Assessor">University Assessor</option>
            <option value="Company Assessor">Company Assessor</option>
        </select>
        
        <input type="submit" name="submit" value="Add Assessor">
    </form>

    <?php if(!empty($message)) echo $message; ?>

    <div style="margin-top: 25px;">
        <a href="AssessorManagement.php" class="btn-outline">Go Back</a>
    </div>
</body>
</html>