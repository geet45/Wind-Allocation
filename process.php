<?php
session_start();

// Check if the user is already logged in, if not redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: login_form.php");
    exit();
}

// Include the database configuration file
include_once 'config.php';

// Check if the energy form has been submitted
if(isset($_POST['energy'])) {
    
    // Get user input from the form
    $energy = $_POST['energy'];

    // Get user's email from the session
    $email = $_SESSION['email'];
	$company = $_SESSION['company'];
	$name=$_SESSION['user_name'];

    // Insert user input into the database
    $sql = "INSERT INTO req_alloc (poc,email,establishment, demand) VALUES ('$name','$email', '$company','$energy')";
    if (mysqli_query($conn, $sql)) {
        echo "Energy requirements stored successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>