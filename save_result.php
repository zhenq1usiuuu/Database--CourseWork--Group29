<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['student_id']);
    $internship_id = intval($_POST['internship_id']);
    
    $tasks = floatval($_POST['tasks']);
    $requirements = floatval($_POST['requirements']);
    $connectivity = floatval($_POST['connectivity']);
    $report = floatval($_POST['report']);
    $language = floatval($_POST['language']);
    $learning = floatval($_POST['learning']);
    $project = floatval($_POST['project']);
    $time = floatval($_POST['time']);
    $comment = $_POST['comment'];

    $total = ($tasks * 0.1) + ($requirements * 0.1) + ($connectivity * 0.1) + ($report * 0.15) + 
             ($language * 0.1) + ($learning * 0.15) + ($project * 0.15) + ($time * 0.15);

    $sql_result = "INSERT INTO result (ID, Tasks_Mark, Health_Mark, Knowledge_Mark, Presentation_Mark, Language_Mark, Activities_Mark, Project_Mark, Time_Mark, Final_Mark, Comments) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                   ON DUPLICATE KEY UPDATE 
                   Tasks_Mark=VALUES(Tasks_Mark), Health_Mark=VALUES(Health_Mark), Knowledge_Mark=VALUES(Knowledge_Mark), 
                   Presentation_Mark=VALUES(Presentation_Mark), Language_Mark=VALUES(Language_Mark), Activities_Mark=VALUES(Activities_Mark), 
                   Project_Mark=VALUES(Project_Mark), Time_Mark=VALUES(Time_Mark), Final_Mark=VALUES(Final_Mark), Comments=VALUES(Comments)";

    $stmt_res = $conn->prepare($sql_result);
    $stmt_res->bind_param("iddddddddds", $student_id, $tasks, $requirements, $connectivity, $report, $language, $learning, $project, $time, $total, $comment);
    $stmt_res->execute();

    $sql_intern = "UPDATE internship SET Final_Average_Mark = ? WHERE ID = ?";
    $stmt_intern = $conn->prepare($sql_intern);
    $stmt_intern->bind_param("di", $total, $internship_id);
    $stmt_intern->execute();

    echo "<script>
            alert('Grading completed successfully! Total Score: " . number_format($total, 2) . "');
            window.location.href = 'view_result.php';
          </script>";
    exit();
}
?>