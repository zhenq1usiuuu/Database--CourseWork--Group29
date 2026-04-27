<?php
session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'University Assessor' && $_SESSION['user_role'] !== 'Company Assessor')) {
    header("Location: Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessor Menu</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .menu-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            width: 450px;
        }
        h1 {
            color: #16325c;
            margin-bottom: 10px;
        }
        .warning-text {
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 25px;
            font-size: 14px;
            display: block;
            line-height: 1.4;
        }
        .menu-btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            background-color: #16325c;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
            box-sizing: border-box;
        }
        .menu-btn:hover {
            background-color: #0d2343;
            transform: translateY(-2px);
        }
        .logout-link {
            display: inline-block;
            margin-top: 20px;
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }
        .logout-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="menu-container">
        <h1>Assessor Menu</h1>
        <span class="warning-text">You can only grade once for each student in the internship. Please grade carefully!</span>
        <a href="select_student.php" class="menu-btn">Grade Students</a>
        <a href="view_result.php" class="menu-btn">View Scores</a>
        <a href="Login.php" class="logout-link">Logout</a>
    </div>
</body>
</html>