<?php
include 'connection.php';

$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

$sql = "SELECT 
            i.ID,
            i.StudentID,
            s.Name AS student_name,
            s.Programme,
            i.Company,
            i.StartDate,
            i.EndDate,
            i.Final_Average_Mark
        FROM internship i
        LEFT JOIN student s ON i.StudentID = s.ID
        WHERE i.StudentID LIKE ? OR s.Name LIKE ?
        ORDER BY i.ID DESC";

$stmt = $conn->prepare($sql);
$likeSearch = "%$search%";
$stmt->bind_param("ss", $likeSearch, $likeSearch);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Internship Management</title>

    <style>
        .internship-page {
            padding: 30px;
            min-height: 100vh;
        }

        .internship-page h2 {
            text-align: center;
            color: #16325c;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 35px;
        }

        .internship-search-box {
            text-align: center;
            margin-bottom: 30px;
        }

        .internship-search-box input[type="text"] {
            padding: 10px 14px;
            width: 330px;
            border: 1px solid #bbb;
            border-radius: 6px;
            font-size: 15px;
        }

        .internship-btn {
            display: inline-block;
            padding: 10px 18px;
            background-color: #16325c;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            margin-left: 8px;
            font-size: 15px;
        }

        .internship-btn:hover {
            background-color: #0f2444;
        }

        .internship-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        .internship-table th {
            background-color: #16325c;
            color: white;
            padding: 12px;
            font-weight: bold;
            text-align: left;
        }

        .internship-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .internship-table tr:hover {
            background-color: #eef3ff;
        }

        .internship-edit {
            color: #16325c;
            font-weight: bold;
            text-decoration: none;
        }

        .internship-edit:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
<div class="internship-page">

<h2>Internship Management</h2>

<form method="GET" class="internship-search-box">
    <input type="text" name="search" placeholder="Search by Student ID or Name"
           value="<?php echo htmlspecialchars($search); ?>">

    <button class="internship-btn" type="submit">Search</button>

    <a class="internship-btn" href="internship_add.php">Add New Internship</a>
</form>

<table class="internship-table">
    <tr>
        <th>ID</th>
        <th>Student ID</th>
        <th>Student Name</th>
        <th>Programme</th>
        <th>Company</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Final Mark</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['ID']; ?></td>
        <td><?php echo htmlspecialchars($row['StudentID']); ?></td>
        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
        <td><?php echo htmlspecialchars($row['Programme']); ?></td>
        <td><?php echo htmlspecialchars($row['Company']); ?></td>
        <td><?php echo $row['StartDate']; ?></td>
        <td><?php echo $row['EndDate']; ?></td>
        <td><?php echo htmlspecialchars($row['Final_Average_Mark']); ?></td>
        <td>
            <a class="internship-edit" href="internship_edit.php?id=<?php echo $row['ID']; ?>">Edit</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</div>
</body>
</html>