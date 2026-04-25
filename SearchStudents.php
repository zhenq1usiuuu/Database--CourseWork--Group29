<?php
session_start();
include 'connection.php';
include 'functions.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: Login.php");
    exit();
}

$all_students = getAllStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    <h2>Search Students</h2>

    <div class="search-card">
        <form id="search-form"> 
            <label for="id">Student ID:</label> 
            <input type="text" id="id" name="id" placeholder="Enter Student ID"> 
            
            <label for="name">Name:</label> 
            <input type="text" id="name" name="name" placeholder="Enter Name"> 
            
            <label for="programme">Programme:</label> 
            <input type="text" id="programme" name="programme" placeholder="Enter Programme"> 
            
            <button type="submit" id="submit-btn" class="btn-primary" style="margin-top: 25px; width: 100%;">Search</button> 
        </form>
    </div>

    <div id="student-list" class="results-container"></div>

    <div style="margin-top: 25px; margin-bottom: 50px;">
        <a href="StudentProfile.php" class="btn-outline">Back to Student Profile</a>
    </div>

    <script>
        const students = <?php echo json_encode($all_students); ?>;
        const form = document.querySelector('#search-form');
        const idInput = document.querySelector('#id');
        const nameInput = document.querySelector('#name');
        const programmeInput = document.querySelector('#programme');
        const resultsContainer = document.querySelector('#student-list');

        function filterStudents(id, name, programme) {
            return students.filter(student => {
                return (!id || student.ID.toString().includes(id)) &&
                       (!name || student.Name.toLowerCase().includes(name.toLowerCase())) &&
                       (!programme || student.Programme.toLowerCase().includes(programme.toLowerCase()));
            });
        }

        form.addEventListener('submit', function(event) {
            event.preventDefault(); 

            const filtered = filterStudents(
                idInput.value, 
                nameInput.value, 
                programmeInput.value
            );

            resultsContainer.innerHTML = '';

            if (filtered.length === 0) {
                resultsContainer.innerHTML = '<div class="message error">No matching students found.</div>';
                return;
            }

            filtered.forEach(item => {
                const card = document.createElement('div');
                card.className = 'result-card'; 
                card.innerHTML = `
                    <div class="res-header">
                        <span class="res-role-tag role-primary">${item.Programme}</span>
                        <h3 class="res-name">${item.Name}</h3>
                    </div>
                    <div class="res-body">
                        <div class="res-info-item">
                            <span class="label">Student ID:</span>
                            <span class="value">${item.ID}</span>
                        </div>
                        <div class="res-info-item">
                            <span class="label">Programme:</span>
                            <span class="value">${item.Programme}</span>
                        </div>
                    </div>
                `;
                resultsContainer.appendChild(card);
            });
        });
    </script>
</body>
</html>