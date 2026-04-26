<?php 
(include 'db.php'); 
$student_id= $_GET['student'] ;
function getStudents($sql){
    global $conn;
    $result = $conn->query($sql);
    return $result;
}
    $sql ="SELECT * FROM student WHERE ID = $student_id";
    $result =getStudents($sql);
    $row =$result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result for <?php echo $row['Name']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Student Result for <?php echo $row['Name']; ?></h1>
    <form method="POST" action ="save_result.php">
    <p><label for="tasks">Undertaking Tasks/Projects(10%):</label>
        <input type="number" id="tasks" name="tasks" min="0" max="100" required>
    </p>
    <p><label for ="requirements">Health and Safety Requirements at the Workplace(10%):</label>
        <input type="number" id ="requirements" name ="requirements" min="0" max="100" required>
    </p>
    <p><label for ="connectivity">Connectivity and Use of Theoretical Knowledge(10%):</label>
        <input type="number" id ="connectivity" name ="connectivity" min="0" max="100" required>
        
    </p>
    <p><label for ="report">Presentation of the Report as a Written Document(15%):</label>
        <input type="number" id ="report" name ="report" min="0" max="100" required>
        
    </p>
    <p><label for ="language">Clarity of Language and Illustration(10%):</label>
        <input type="number" id ="language" name ="language" min="0" max="100" required> 
       
    </p>
    <p><label for ="learning">Lifelong Learning Activities(15%):</label>
        <input type="number" id ="learning" name ="learning" min="0" max="100" required>     
        
    </p>
    <p><label for ="project">Project Management(15%):</label>
        <input type="number" id ="project" name ="project" min="0" max="100" required> 
        
    </p>
    <p><label for ="time">Time Management(15%):</label>
        <input type="number" id ="time" name ="time" min="0" max="100" required>         
        
    </p>
    <p>
        <label for="comment">Your Comments:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" placeholder="Please provide qualitative comments to justify the scores given." required ></textarea>
    </p>
    <button type="submit" onclick="return validateForm()">Submit!</button>
    <button type="reset">Reset!</button>
</form>
<script src="script.js"></script>
</body>
</html>