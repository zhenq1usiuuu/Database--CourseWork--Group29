<?php
session_start();
include 'connection.php';
include 'functions.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: Login.php");
    exit();
}

$all_assessors = getAllAssessors();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Assessors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>E-Internship</h1>
    <h2>Search Assessors</h2>

    <div class="search-card">
        <form id="search-form"> 
            <label for="id">Assessor ID:</label> 
            <input type="text" id="id" name="id" placeholder="Enter ID"> 
            
            <label for="name">Name:</label> 
            <input type="text" id="name" name="name" placeholder="Enter Name"> 
            
            <label for="username">Username:</label> 
            <input type="text" id="username" name="username" placeholder="Enter Username"> 
            
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="">All Roles</option>
                <option value="University Assessor">University Assessor</option>
                <option value="Company Assessor">Company Assessor</option>
            </select>
            
            <button type="submit" id="submit-btn" class="btn-primary" style="margin-top: 25px; width: 100%;">Search</button>
        </form>
    </div><br><br>
    <a href="AssessorManagement.php" class="btn-outline">Go Back</a>


    <section id="results-section"> 
        <h2>Search Results</h2> 
        <div id="results-container" class="results-grid"></div>
    </section>

    <script>
        const assessors = <?php echo json_encode($all_assessors); ?>;
        
        const form = document.querySelector('#search-form');
        const idInput = document.querySelector('#id');
        const nameInput = document.querySelector('#name');
        const usernameInput = document.querySelector('#username');
        const roleInput = document.querySelector('#role');
        const resultsContainer = document.querySelector('#results-container');

        function filterAssessors(id, name, username, role) {
            return assessors.filter(assessor => {
                return (!id || assessor.ID.toString().includes(id)) &&
                       (!name || assessor.Name.toLowerCase().includes(name.toLowerCase())) &&
                       (!username || assessor.Username.toLowerCase().includes(username.toLowerCase())) &&
                       (!role || assessor.Role === role);
            });
        }

        form.addEventListener('submit', function(event) {
            event.preventDefault(); 

            const filtered = filterAssessors(
                idInput.value, 
                nameInput.value, 
                usernameInput.value, 
                roleInput.value
            );

            resultsContainer.innerHTML = '';

            if (filtered.length === 0) {
                resultsContainer.innerHTML = '<div class="message error">No matching assessors found.</div>';
                return;
            }

            filtered.forEach(item => {
                const card = document.createElement('div');
                card.className = 'result-card'; 
                card.innerHTML = `
                    <div class="res-header">
                        <span class="res-role-tag ${item.Role === 'University Assessor' ? 'role-uni' : 'role-comp'}">${item.Role}</span>
                        <h3 class="res-name">${item.Name}</h3>
                    </div>
                    <div class="res-body">
                        <div class="res-info-item">
                            <span class="label">Assessor ID:</span>
                            <span class="value">${item.ID}</span>
                        </div>
                        <div class="res-info-item">
                            <span class="label">Username:</span>
                            <span class="value">${item.Username}</span>
                        </div>
                    </div>
                    <div class="res-actions" style="margin-top: 20px; display: flex; gap: 10px; border-top: 1px solid #eee; padding-top: 15px;">
                        <a href="update_assessor.php?id=${item.ID}" class="btn-edit" style="background-color: #4CAF50; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 0.9em; flex: 1; text-align: center;">Update</a>
                        <a href="delete_assessor.php?id=${item.ID}" class="btn-delete" style="background-color: #f44336; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 0.9em; flex: 1; text-align: center;">Delete</a>
                    </div>
                `;
                resultsContainer.appendChild(card);
            });
        });

        form.dispatchEvent(new Event('submit'));
    </script>
</body>
</html>