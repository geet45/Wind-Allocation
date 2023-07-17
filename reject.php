<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: login.php');
    exit();
}

require_once 'config.php';

$email = $_POST['email'];

// Prepare the SQL statement with a parameter placeholder
$query = "DELETE FROM user_req where email = ?";
$stmt = mysqli_prepare($db, $query);
if (!$stmt) {
    die('Failed to prepare statement: ' . mysqli_error($db));
}

// Bind the email value to the parameter placeholder
mysqli_stmt_bind_param($stmt, 's', $email);

// Execute the prepared statement
if (mysqli_stmt_execute($stmt)) {
    echo "Rejected";
    sleep(1);
    $url = "new-user-requests.php";
    echo "<script>location.href='$url';</script>";
    exit();
} else {
    die('Failed to delete record: ' . mysqli_error($db));
}
?>
