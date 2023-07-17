<?php

// Connect to the database
@include 'config.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$poc = $_POST['poc'];
$establishment = $_POST['establishment'];
$address = $_POST['address'];
$consumer_type = $_POST['consumer_type'];
$division = $_POST['division'];
$sub_division = $_POST['sub_division'];
$rr_no = $_POST['rr_no'];
$energy_wheeled = $_POST['energy_wheeled'];

// Insert data into table
$sql = "INSERT INTO all_details (poc, establishment, address, consumer_type, division, sub_division, rr_no, energy_wheeled) VALUES ('$poc', '$establishment', '$address', '$consumer_type', '$division', '$sub_division', '$rr_no', '$energy_wheeled')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
}else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>
