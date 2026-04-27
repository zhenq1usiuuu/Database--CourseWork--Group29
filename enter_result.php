<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$assessor_id = intval($_SESSION['user_id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['student_id']);
    $internship_id = intval($_POST['internship_id']);
    
    $check_sql = "SELECT ID FROM result WHERE InternshipID = ? AND AssessorID = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $internship_id, $assessor_id);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows > 0) {
        echo "<script>alert('Graded Already. You can only grade once.'); window.location.href='AssessorMenu.php';</script>";
        exit();
    }

    $tasks = floatval($_POST['tasks']);
    $requirements = floatval($_POST['requirements']);
    $connectivity = floatval($_POST['connectivity']);
    $report = floatval($_POST['report']);
    $language = floatval($_POST['language']);
    $learning = floatval($_POST['learning']);
    $project = floatval($_POST['project']);
    $time = floatval($_POST['time']);
    $comment = $_POST['comment'];

    $individual_total = ($tasks * 0.1) + ($requirements * 0.1) + ($connectivity * 0.1) + ($report * 0.15) + 
                        ($language * 0.1) + ($learning * 0.15) + ($project * 0.15) + ($time * 0.15);

    $sql_result = "INSERT INTO result (InternshipID, AssessorID, Tasks_Mark, Health_Mark, Knowledge_Mark, Presentation_Mark, Language_Mark, Activities_Mark, Project_Mark, Time_Mark, Final_Mark, Comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_res = $conn->prepare($sql_result);
    $stmt_res->bind_param("iiddddddddds", $internship_id, $assessor_id, $tasks, $requirements, $connectivity, $report, $language, $learning, $project, $time, $individual_total, $comment);
    $stmt_res->execute();

    $avg_sql = "SELECT AVG(Final_Mark) as average_score FROM result WHERE InternshipID = ?";
    $avg_stmt = $conn->prepare($avg_sql);
    $avg_stmt->bind_param("i", $internship_id);
    $avg_stmt->execute();
    $final_average = ($avg_stmt->get_result()->fetch_assoc())['average_score'];

    $sql_intern = "UPDATE internship SET Final_Average_Mark = ? WHERE ID = ?";
    $stmt_intern = $conn->prepare($sql_intern);
    $stmt_intern->bind_param("di", $final_average, $internship_id);
    $stmt_intern->execute();

    echo "<script>
            alert('Grading submitted successfully! Your score: " . number_format($individual_total, 2) . "');
            window.location.href = 'view_result.php';
          </script>";
    exit();
}

if (!isset($_GET['student']) || !isset($_GET['internship_id'])) {
    header("Location: select_student.php");
    exit();
}

$student_id = intval($_GET['student']);
$internship_id = intval($_GET['internship_id']);

$check_sql = "SELECT ID FROM result WHERE InternshipID = ? AND AssessorID = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $internship_id, $assessor_id);
$check_stmt->execute();
if ($check_stmt->get_result()->num_rows > 0) {
    echo "<script>alert('Graded Already. You can only grade once.'); window.location.href='AssessorMenu.php';</script>";
    exit();
}

$sql = "SELECT s.Name, i.Company FROM student s 
        JOIN internship i ON s.ID = i.StudentID 
        WHERE s.ID = ? AND i.ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $student_id, $internship_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("No matching internship record found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grading</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h1>Grading Form</h1>
    <h3>Student: <?php echo htmlspecialchars($data['Name']); ?></h3>
    <h3>Company: <?php echo htmlspecialchars($data['Company']); ?></h3>

    <form method="POST" action="enter_result.php">
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
        <input type="hidden" name="internship_id" value="<?php echo $internship_id; ?>">

        <p>
            <label for="tasks">Undertaking Tasks/Projects (10%):</label>
            <input type="number" id="tasks" name="tasks" min="0" max="100" required>
        </p>
        <p>
            <label for="requirements">Health and Safety Requirements (10%):</label>
            <input type="number" id="requirements" name="requirements" min="0" max="100" required>
        </p>
        <p>
            <label for="connectivity">Connectivity and Use of Knowledge (10%):</label>
            <input type="number" id="connectivity" name="connectivity" min="0" max="100" required>
        </p>
        <p>
            <label for="report">Written Report Presentation (15%):</label>
            <input type="number" id="report" name="report" min="0" max="100" required>
        </p>
        <p>
            <label for="language">Clarity of Language (10%):</label>
            <input type="number" id="language" name="language" min="0" max="100" required>
        </p>
        <p>
            <label for="learning">Lifelong Learning Activities (15%):</label>
            <input type="number" id="learning" name="learning" min="0" max="100" required>
        </p>
        <p>
            <label for="project">Project Management (15%):</label>
            <input type="number" id="project" name="project" min="0" max="100" required>
        </p>
        <p>
            <label for="time">Time Management (15%):</label>
            <input type="number" id="time" name="time" min="0" max="100" required>
        </p>
        <p>
            <label for="comment">Overall Comments:</label><br>
            <textarea id="comment" name="comment" rows="4" cols="50" required></textarea>
        </p>
        
        <button type="submit">Submit Grades</button>
        <br><br>
        <a href="select_internship.php?student=<?php echo $student_id; ?>">Back to Internship Selection</a>
    </form>
</body>
</html>