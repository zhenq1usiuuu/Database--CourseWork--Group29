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
    <style>
        .btn-back {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #f8f9fa;
            color: #16325c;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid #16325c;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #16325c;
            color: white;
            transform: translateX(-5px);
        }
        .results-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            width: 100%;
        }
        .result-card {
            flex: 0 1 calc(50% - 20px);
            min-width: 320px;
            box-sizing: border-box;
        }
        .message.error {
            text-align: center;
            width: 100%;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .result-card {
                flex: 0 1 100%;
            }
        }
    </style>
</head>
<body>
    <h1>E-Internship</h1>
    <h2 style="text-align: center;">Search Students</h2>

    <a href="AdminMenu.php" class="btn-back">← Go Back to Admin Menu</a>

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

    <section id="results-section"> 
        <h2 style="text-align: center;">Search Results</h2> 
        <div id="results-container" class="results-grid"></div>
    </section>

    <script>
        const students = <?php echo json_encode($all_students); ?>;
        
        const form = document.querySelector('#search-form');
        const idInput = document.querySelector('#id');
        const nameInput = document.querySelector('#name');
        const programmeInput = document.querySelector('#programme');
        const resultsContainer = document.querySelector('#results-container');

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
                    <div class="res-actions" style="margin-top: 20px; display: flex; gap: 10px; border-top: 1px solid #eee; padding-top: 15px;">
                        <a href="update_student.php?id=${item.ID}" class="btn-edit" style="background-color: #4CAF50; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 0.9em; flex: 1; text-align: center;">Update</a>
                        <a href="delete_student.php?id=${item.ID}" class="btn-delete" style="background-color: #f44336; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 0.9em; flex: 1; text-align: center;">Delete</a>
                    </div>
                `;
                resultsContainer.appendChild(card);
            });
        });

        form.dispatchEvent(new Event('submit'));
    </script>
</body>
</html>