<?php
include 'connection.php';

if (!isset($_GET['id'])) {
    header("Location: Internship.php");
    exit();
}

$internship_id = intval($_GET['id']);

$info_sql = "SELECT i.Company, s.Name AS StudentName 
             FROM internship i 
             JOIN student s ON i.StudentID = s.ID 
             WHERE i.ID = ?";
$stmt_info = $conn->prepare($info_sql);
$stmt_info->bind_param("i", $internship_id);
$stmt_info->execute();
$info = $stmt_info->get_result()->fetch_assoc();

$details_sql = "SELECT r.*, u.Name AS AssessorName, u.Role 
                FROM result r 
                JOIN User u ON r.AssessorID = u.ID 
                WHERE r.InternshipID = ?";
$stmt_details = $conn->prepare($details_sql);
$stmt_details->bind_param("i", $internship_id);
$stmt_details->execute();
$results = $stmt_details->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grading Details</title>
    <style>
        body { font-family: sans-serif; padding: 40px; background: #f4f7f6; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
        h2, h3 { color: #16325c; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .assessor-box { border: 1px solid #ddd; padding: 15px; border-radius: 5px; background: #fafafa; }
        .score-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; }
        .score-label { font-weight: bold; color: #555; }
        .comment-box { margin-top: 15px; padding: 10px; background: #fff; border-left: 4px solid #16325c; font-style: italic; }
        .final-score { font-size: 20px; font-weight: bold; color: #16325c; margin-top: 10px; text-align: right; }
        .btn-back { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #16325c; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Grading Details for <?php echo htmlspecialchars($info['StudentName']); ?></h2>
    <p><strong>Company:</strong> <?php echo htmlspecialchars($info['Company']); ?> | <strong>Internship ID:</strong> <?php echo $internship_id; ?></p>
    
    <div class="detail-grid">
        <?php while($row = $results->fetch_assoc()): ?>
        <div class="assessor-box">
            <h3><?php echo htmlspecialchars($row['AssessorName']); ?></h3>
            <p><small><?php echo htmlspecialchars($row['Role']); ?></small></p>
            
            <div class="score-item"><span class="score-label">Tasks (10%)</span> <span><?php echo $row['Tasks_Mark']; ?></span></div>
            <div class="score-item"><span class="score-label">Health (10%)</span> <span><?php echo $row['Health_Mark']; ?></span></div>
            <div class="score-item"><span class="score-label">Knowledge (10%)</span> <span><?php echo $row['Knowledge_Mark']; ?></span></div>
            <div class="score-item"><span class="score-label">Presentation (15%)</span> <span><?php echo $row['Presentation_Mark']; ?></span></div>
            <div class="score-item"><span class="score-label">Language (10%)</span> <span><?php echo $row['Language_Mark']; ?></span></div>
            <div class="score-item"><span class="score-label">Activities (15%)</span> <span><?php echo $row['Activities_Mark']; ?></span></div>
            <div class="score-item"><span class="score-label">Project (15%)</span> <span><?php echo $row['Project_Mark']; ?></span></div>
            <div class="score-item"><span class="score-label">Time (15%)</span> <span><?php echo $row['Time_Mark']; ?></span></div>
            
            <div class="comment-box">
                <strong>Comments:</strong><br>
                <?php echo nl2br(htmlspecialchars($row['Comments'])); ?>
            </div>
            <div class="final-score">Total: <?php echo number_format($row['Final_Mark'], 2); ?></div>
        </div>
        <?php endwhile; ?>
    </div>
    
    <a href="Internship.php" class="btn-back">Back to List</a>
</div>
</body>
</html>