<?php
function executePreparedStatement($sql, $params) {
global $conn;
$stmt = $conn->prepare($sql);
if (!empty($params)) {
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
if (stripos($sql, "SELECT") === 0) {
$stmt->execute();
$result = $stmt->get_result();
} else {
$result = $stmt->execute();
$stmt->get_result();
}
$stmt->close();
return $result;
}

function createUser($name, $username, $password, $role) {
$sql = "INSERT INTO user (name, username, password, role) VALUES(?, ?, ?, ?)";
$params = [$name, $username, $password, $role];
return executePreparedStatement($sql, $params);
}
function getStudents() {
$sql = "SELECT * FROM Student";
return executePreparedStatement($sql, []);
}
function updateStudent($id, $name, $programme) {
$sql = "UPDATE Student SET Name = ?, Programme = ? WHERE ID = ?";
$params = [$name, $programme, $id];
return executePreparedStatement($sql, $params);
}
function deleteStudent($id) {
$sql = "DELETE FROM Student WHERE ID = ?";
$params = [$id];
return executePreparedStatement($sql, $params);
}
function createStudent($name, $programme) {
$sql = "INSERT INTO Student (Name, Programme) VALUES(?, ?)";
$params = [$name, $programme];
return executePreparedStatement($sql, $params);
}
function getStudentByID($id) {
$sql = "SELECT * FROM Student WHERE ID = ?";
$params = [$id];
return executePreparedStatement($sql, $params);
}
function getAssessors() {
$sql = "SELECT * FROM User WHERE Role = 'University Assessor' OR Role = 'Company Assessor'";
return executePreparedStatement($sql, []);
}
function updateAssessor($id, $name, $username, $password, $role) {
$sql = "UPDATE User SET Name = ?, Username = ?, Password = ?, Role = ? WHERE ID = ?";
$params = [$name, $username, $password, $role, $id];
return executePreparedStatement($sql, $params);
}
function deleteAssessor($id) {
$sql = "DELETE FROM User WHERE ID = ?";
$params = [$id];
return executePreparedStatement($sql, $params);
}
function getAssessorsById($id) {
$sql = "SELECT * FROM User WHERE ID = ?";
$params = [$id];
return executePreparedStatement($sql, $params);
}
function getUserByUsername($username) {
$sql = "SELECT * FROM User WHERE Username = ?";
$params = [$username];
return executePreparedStatement($sql, $params);
}

function correctLogin($username, $password, $role) {
    $sql = "SELECT ID, Name, Role FROM user WHERE Username = ? AND Password = ? AND Role = ?";
    $params = [$username, $password, $role];
    $result = executePreparedStatement($sql, $params);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['user_role'] = $user['Role'];
        $name = $user['Name'];

        $redirect_page = ($user['Role'] === 'Admin') ? "AdminMenu.php" : "AssessorMenu.php";

        echo "<script>
                alert('Login Successful! Welcome, " . $name . "');
                window.location.href = '" . $redirect_page . "';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error: Invalid Username, Password, or Role');
                window.history.back();
              </script>";
    }
}
function getAssessorRequests() {
$sql = "SELECT * FROM User WHERE Role LIKE 'Request: %'";
return executePreparedStatement($sql, []);
}
function acceptAssessor($id, $role) {
if ($role == 'Request: University Assessor') {
$sql = "UPDATE User SET Role = 'University Assessor' WHERE ID = ?";
$params = [$id];
return executePreparedStatement($sql, $params);
} else{
$sql = "UPDATE User SET Role = 'Company Assessor' WHERE ID = ?";
$params = [$id];
return executePreparedStatement($sql, $params);
}
}
function getAllAssessors() {
    
    $sql = "SELECT ID, Name, Username, Role FROM User WHERE Role IN ('University Assessor', 'Company Assessor')";
    $result = executePreparedStatement($sql, []);
    
    $assessors = [];
    while ($row = $result->fetch_assoc()) {
        $assessors[] = $row;
    }
    return $assessors;
}
function getAllStudents(){
    $sql = "SELECT ID, Name, Programme FROM Student";
    $result = executePreparedStatement($sql, []);
    
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    return $students;
}
?>


