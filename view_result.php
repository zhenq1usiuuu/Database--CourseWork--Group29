<?php include 'db.php';
$search ="";
if (isset($_GET['search'])){
    $search = $_GET['search'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Internship Results</h2>
    <form method="GET">
        <label for ="search">Search by Student Name:</label>
        <input type ="text" id ="search" name ="search" placeholder="Enter student name" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" onclick="return confirmSubmit()">Submit</button></form>
    
    <br>
    <table border="1">
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Programme</th>
            <th>Final Mark</th>
            <th>Comments</th>
            <th>Tasks Mark</th>
            <th>Health Mark</th>
            <th>Knowledge Mark</th> 
            <th>Presentation Mark</th>
            <th>Language Mark</th>
            <th>Activities Mark</th>
            <th>Project Mark</th>
            <th>Time Mark</th>
        </tr>
        <?php
        $sql = "SELECT s.ID, s.Name, s.Programme, r.Final_Mark, r.Comments, r.Tasks_Mark, r.Health_Mark, r.Knowledge_Mark, r.Presentation_Mark, r.Language_Mark, r.Activities_Mark, r.Project_Mark, r.Time_Mark FROM student s  LEFT JOIN result r ON s.ID = r.ID WHERE s.Name LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_param = "%$search%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()){
   echo "<tr>
        <td>{$row['ID']}</td>  <!--table data-->
        <td>{$row['Name']}</td>
        <td>{$row['Programme']}</td>
        <td>{$row['Final_Mark']}</td>
        <td>{$row['Comments']}</td>
        <td>{$row['Tasks_Mark']}</td>
        <td>{$row['Health_Mark']}</td>
        <td>{$row['Knowledge_Mark']}</td>
        <td>{$row['Presentation_Mark']}</td>
        <td>{$row['Language_Mark']}</td>
        <td>{$row['Activities_Mark']}</td>
        <td>{$row['Project_Mark']}</td>
        <td>{$row['Time_Mark']}</td>
</tr>";
}
        ?>
    </table>
    <br><br>
    <form action="select_student.php">
        <button type="submit" onclick="goBackConfirm()">Back</button>
    </form>
    <script src="script.js"></script>
</body>
</html>