<?php (include 'db.php');//include the database connection file?>     
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Select Student</h1>
    <form method ="GET" action ="enter_result.php"> <!--to enter_resullt.php-->
        <label for="student">Student:</label>
        <select id ="student" name ="student"> <!--id:CSS,JS.naem:server,PHP-->
    <?php
function getStudents($sql){
    global $conn;
    $result = $conn->query($sql);
    return $result;
}
    $sql ="SELECT * FROM student";
    $result =getStudents($sql);
    if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){//take out each row of data and convert it  into an associative array
        echo"<option value='".$row['ID']."'>".$row['ID']."-".$row['Name']."-".$row['Programme']."</option>";//use dot to concatenate strings and variables
    }
}else{
    echo"<option value=''>No students found</option>";
}

?>
</select>
<br><br>
        <button type="submit" onclick="return confirmSubmit()">Go!</button>

    </form>
<script src="script.js"></script>   
</body>
</html>
