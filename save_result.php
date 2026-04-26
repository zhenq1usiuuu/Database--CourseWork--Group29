<?php include 'db.php'; 
$student_id =$_POST['student_id'];
$tasks =$_POST['tasks'];
$requirements =$_POST['requirements'];
$connectivity =$_POST['connectivity'];
$report =$_POST['report'];
$language =$_POST['language'];
$learning =$_POST['learning'];
$project =$_POST['project'];
$time =$_POST['time'];
$comment =$_POST['comment'];
$total=$tasks*0.1+$requirements*0.1+$connectivity*0.1+$report*0.15+$language*0.1+$learning*0.15+$project*0.15+$time*0.15;
$sql ="INSERT INTO result (ID,Tasks_Mark,Health_Mark,Knowledge_Mark,Presentation_Mark,Language_Mark,Activities_Mark,Project_Mark,Time_Mark,Final_Mark,Comments) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iddddddddds", $student_id, $tasks, $requirements, $connectivity, $report, $language, $learning, $project, $time, $total, $comment);
$stmt->execute();

header("Location: view_result.php");
exit();
?>