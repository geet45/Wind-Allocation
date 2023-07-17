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
	$company = $_SESSION['establishment'];
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


<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			font-family: sans-serif;
		}
		.sidebar {
			position: fixed;
			left: 0;
			top: 0;
			width: 200px;
			height: 100%;
			background: #202040;
			color: #fff;
			padding: 20px;
			box-sizing: border-box;
		}
		.sidebar ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}
		.sidebar li {
			margin-bottom: 10px;
		}
		.sidebar a {
			display: block;
			padding: 10px;
			color: #fff;
			text-decoration: none;
		}
		.sidebar a:hover {  
			background: #4c4f8a;
		}
		.content {
			margin-left: 200px;
			padding: 20px;
		}
		/* styles for the announcements marquee */
		.announcements {
			margin-top: 20px;
			background-color: #f1f1f1;
			padding: 10px;
			overflow: hidden;
		}
		.announcements h2 {
			margin: 0;
			text-align: center;
		}
		.announcements p {
			margin: 0;
			display: inline-block;
			white-space: nowrap;
			margin-right: 100%;
			animation: marquee 15s linear infinite;
		}
		/* keyframes for the announcements marquee animation */
		@keyframes marquee {
			0% { transform: translateX(100%); }
			100% { transform: translateX(-100%); }
		}
	</style>
</head>
<body>
	<div class="sidebar">
		<ul>
			<li><a href="#">Dashboard</a></li>
			<li><a href="#">Users</a></li>
			<li><a href="#">Products</a></li>
			<li><a href="#">Settings</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</div>
	<div class="content">
		<h1 style="text-align: center;">User Dashboard</h1>
		<div class="announcements">
			<h2>Announcements:</h2>
			<?php
				// code to fetch announcements from the database and display them in the marquee
				include 'config.php';
				$sql = "SELECT * FROM announcements WHERE is_active=true";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) {
					echo '<br><p>';
					while ($row = mysqli_fetch_assoc($result)) {
						echo $row['description'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					}
					echo '</p><br>';
				} else {
					echo '<p>No active announcements.</p>';
				}
			?>
		</div>
		<hr>
		<h2>Enter your energy requirements:</h2>
		<form method="post" action="process.php">
			<label for="energy">Energy requirements:</label>
			<input type="number" id="energy" name="energy" required><br><br>
			<input type="submit" value="Submit">
		</form>
