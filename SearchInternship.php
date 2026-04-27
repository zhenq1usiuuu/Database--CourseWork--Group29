<?php
session_start();
include 'connection.php';
include 'functions.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: Login.php");
    exit();
}

$sql = "SELECT 
            i.ID,
            i.StudentID,
            s.Name AS student_name,
            s.Programme,
            u1.Name AS uni_name,
            u2.Name AS comp_name,
            i.Company,
            i.StartDate,
            i.EndDate,
            i.Final_Average_Mark
        FROM internship i
        LEFT JOIN student s ON i.StudentID = s.ID
        LEFT JOIN User u1 ON i.Uni_AssessorID = u1.ID
        LEFT JOIN User u2 ON i.Com_AssessorID = u2.ID";

$res = $conn->query($sql);
$data = [];
while($row = $res->fetch_assoc()) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Internship</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .btn-back { display: inline-block; margin-bottom: 20px; padding: 10px 20px; background-color: #f4f4f4; color: #333; text-decoration: none; border-radius: 4px; border: 1px solid #ddd; font-weight: bold; }
        .results-grid { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; width: 100%; }
        .result-card { flex: 0 1 calc(50% - 20px); min-width: 350px; box-sizing: border-box; }
        .message.error { text-align: center; width: 100%; padding: 20px; }
        .status-tag { font-size: 0.8em; padding: 2px 8px; border-radius: 12px; margin-left: 10px; }
        .status-pending { background-color: #ffeaa7; color: #d63031; }
        .status-graded { background-color: #55efc4; color: #00b894; }
        @media (max-width: 800px) { .result-card { flex: 0 1 100%; } }
    </style>
</head>
<body>
    <h1>E-Internship</h1>
    <h2 style="text-align: center;">Internship Search</h2>
    
    <a href="Internship.php" class="btn-back">Go Back</a>

    <div class="search-card">
        <form id="search-form"> 
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label>Student Name / ID:</label> 
                    <input type="text" id="student_input" placeholder="Name or ID">
                </div>
                <div>
                    <label>Programme:</label> 
                    <input type="text" id="programme_input" placeholder="e.g. Computer Science">
                </div>
                <div>
                    <label>University Assessor:</label> 
                    <input type="text" id="uni_input" placeholder="Uni Assessor Name">
                </div>
                <div>
                    <label>Company Assessor:</label> 
                    <input type="text" id="comp_assessor_input" placeholder="Company Assessor Name">
                </div>
                <div>
                    <label>Company Name:</label> 
                    <input type="text" id="company_input" placeholder="Company Name">
                </div>
                <div>
                    <label>Grading Status:</label>
                    <select id="status_input">
                        <option value="all">All Records</option>
                        <option value="pending">Pending (Not Graded)</option>
                        <option value="graded">Graded</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" id="submit-btn" class="btn-primary" style="margin-top: 25px; width: 100%;">Search</button>
        </form>
    </div>

    <section id="results-section"> 
        <h2 style="text-align: center;">Search Results</h2> 
        <div id="results-container" class="results-grid"></div>
    </section>

    <script>
        const records = <?php echo json_encode($data); ?>;
        const form = document.querySelector('#search-form');
        const resultsContainer = document.querySelector('#results-container');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); 
            
            const sQuery = document.querySelector('#student_input').value.toLowerCase();
            const pQuery = document.querySelector('#programme_input').value.toLowerCase();
            const uQuery = document.querySelector('#uni_input').value.toLowerCase();
            const caQuery = document.querySelector('#comp_assessor_input').value.toLowerCase();
            const cQuery = document.querySelector('#company_input').value.toLowerCase();
            const statusFilter = document.querySelector('#status_input').value;

            const filtered = records.filter(r => {
                const hasMark = (r.Final_Average_Mark !== null && r.Final_Average_Mark !== "" && r.Final_Average_Mark != 0);
                
                const matchStatus = (statusFilter === 'all') || 
                                    (statusFilter === 'pending' && !hasMark) || 
                                    (statusFilter === 'graded' && hasMark);

                return matchStatus &&
                       (!sQuery || (r.student_name && r.student_name.toLowerCase().includes(sQuery)) || r.StudentID.toString().includes(sQuery)) &&
                       (!pQuery || (r.Programme && r.Programme.toLowerCase().includes(pQuery))) &&
                       (!uQuery || (r.uni_name && r.uni_name.toLowerCase().includes(uQuery))) &&
                       (!caQuery || (r.comp_name && r.comp_name.toLowerCase().includes(caQuery))) &&
                       (!cQuery || (r.Company && r.Company.toLowerCase().includes(cQuery)));
            });

            resultsContainer.innerHTML = '';
            if (filtered.length === 0) {
                resultsContainer.innerHTML = '<div class="message error">No internship records found matching these criteria.</div>';
                return;
            }

            filtered.forEach(item => {
                const isGraded = (item.Final_Average_Mark !== null && item.Final_Average_Mark != 0);
                const statusHtml = isGraded ? 
                    `<span class="status-tag status-graded">Mark: ${item.Final_Average_Mark}</span>` : 
                    `<span class="status-tag status-pending">Pending</span>`;

                const card = document.createElement('div');
                card.className = 'result-card'; 
                card.innerHTML = `
                    <div class="res-header">
                        <span class="res-role-tag role-primary">${item.Company}</span>
                        <h3 class="res-name">${item.student_name} ${statusHtml}</h3>
                    </div>
                    <div class="res-body">
                        <div class="res-info-item">
                            <span class="label">Programme:</span>
                            <span class="value">${item.Programme}</span>
                        </div>
                        <div class="res-info-item">
                            <span class="label">Uni Assessor:</span>
                            <span class="value">${item.uni_name}</span>
                        </div>
                        <div class="res-info-item">
                            <span class="label">Comp Assessor:</span>
                            <span class="value">${item.comp_name}</span>
                        </div>
                        <div class="res-info-item">
                            <span class="label">Period:</span>
                            <span class="value">${item.StartDate} to ${item.EndDate}</span>
                        </div>
                    </div>
                    <div class="res-actions" style="margin-top: 20px; display: flex; gap: 10px; border-top: 1px solid #eee; padding-top: 15px;">
                        <a href="internship_edit.php?id=${item.ID}" style="background-color: #4CAF50; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; flex: 1; text-align: center;">Update</a>
                        <a href="internship_delete.php?id=${item.ID}" style="background-color: #f44336; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; flex: 1; text-align: center;">Delete</a>
                    </div>
                `;
                resultsContainer.appendChild(card);
            });
        });

        form.dispatchEvent(new Event('submit'));
    </script>
</body>
</html>