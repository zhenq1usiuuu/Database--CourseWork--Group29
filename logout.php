<?php
session_start();

$_SESSION = array();

session_destroy();

echo "<script>
        alert('You have been logged out successfully.');
        window.location.href = 'Login.php';
      </script>";
exit();
?>