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
    $Username = $_POST['username'];
    $Password = $_POST['password'];
    $Role = $_POST['role'];
    
    if (empty($name) || empty($Username)) {
        $message = "<div class='message error'>Name and username are required.</div>";
    } else {
        $result = updateAssessor($id, $name, $Username, $Password, $Role);
        if ($result) {
            $message = "<div class='message success'>Assessor updated successfully. Redirecting...</div>";
            header("Refresh:3; url=AssessorManagement.php");
        } else {
            $message = "<div class='message error'>Failed to update assessor: " . $conn->error . "</div>";
        }
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
    <title>Update Assessor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    <h2>Update Assessor</h2>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="ID" value="<?php echo htmlspecialchars($id); ?>">
        
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
        
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>" required>
        
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="University Assessor" <?php if ($role === 'University Assessor') echo 'selected'; ?>>University Assessor</option>
            <option value="Company Assessor" <?php if ($role === 'Company Assessor') echo 'selected'; ?>>Company Assessor</option>
        </select>
        
        <input type="submit" name="submit" value="Update Assessor">
    </form>

    <?php if(!empty($message)) echo $message; ?>

    <div style="margin-top: 25px;">
        <a href="AssessorManagement.php" class="btn-outline">Go Back</a>
    </div>
</body>
</html>