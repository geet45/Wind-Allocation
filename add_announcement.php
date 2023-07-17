<?php
// Database connection details
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$title = $_POST['title'];
$description = $_POST['description'];
$is_active = isset($_POST['is_active']) ? 1 : 0;
$created_at = date('Y-m-d H:i:s');

// Prepare and execute the SQL statement
$sql = "INSERT INTO announcements (title, description, is_active, created_at)
        VALUES ('$title', '$description', '$is_active', '$created_at')";


if ($conn->query($sql) === TRUE) {
    $message = "Announcement added successfully.";
    $status = "success";
} else {
    $message = "Error adding announcement: " . $conn->error;
    $status = "error";
}

// Close the database connection
$conn->close();
?>

