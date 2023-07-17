<?php

// Connect to the database
@include 'config.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Validate and sanitize input data
$title = isset($_POST['title']) ? mysqli_real_escape_string($conn, $_POST['title']) : '';
$description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
$active = isset($_POST['is_active']) ? intval($_POST['is_active']) : 0;

// Insert data into table
if (!empty($title) && !empty($description)) {
    $sql = "INSERT INTO announcements (title, description, is_active) VALUES ('$title', '$description', $active)";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Error: Missing required data";
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
		table {
			border-collapse: collapse;
			width: 70%;
			color: white;
		}
		th, td {
			padding: 8px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}
		th {
			background-color: #002266;
			color: white;
		}
		tr:hover {
			background-color:#f5f5f5;
		}
		table tr:nth-child(even) {
    		background-color:  #1a66ff
		}
		table tr:nth-child(odd) {
    		background-color:  #6699ff;
		}


		.button-15 {
  background-image: linear-gradient(#42A1EC, #0070C9);
  border: 1px solid #0077CC;
  border-radius: 4px;
  box-sizing: border-box;
  color: #FFFFFF;
  cursor: pointer;
  direction: ltr;
  display: block;
  font-family: "SF Pro Text","SF Pro Icons","AOS Icons","Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 17px;
  font-weight: 400;
  letter-spacing: -.022em;
  line-height: 1.47059;
  min-width: 30px;
  overflow: visible;
  padding: 4px 15px;
  text-align: center;
  vertical-align: baseline;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  white-space: nowrap;
}

.button-15:disabled {
  cursor: default;
  opacity: .3;
}

.button-15:hover {
  background-image: linear-gradient(#51A9EE, #147BCD);
  border-color: #1482D0;
  text-decoration: none;
}

.button-15:active {
  background-image: linear-gradient(#3D94D9, #0067B9);
  border-color: #006DBC;
  outline: none;
}

.button-15:focus {
  box-shadow: rgba(131, 192, 253, 0.5) 0 0 0 3px;
  outline: none;
}

	</style>

</head>
<body>
<script>
		function hideButton() {
		var button = document.getElementById("myButton");
		button.style.display = "none";
		}
	</script>
	<div class="sidebar">
		<ul>
			<li><a href="#">Dashboard</a></li>
			<li><a href="new-user-requests.php">Users Request</a></li>
			<li><a href="all_details.php">Form C</a></li>
			<li><a href="add_ann.php">Annoncements</a></li>
			<li><a href="#">Settings</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</div>
	<div class="content">
        <h1>Annnouncements</h1>
        <form method="post" action="">
            <label for="username">Information to be announced:</label>
            <input type="text" id="announce" name="announce" required><br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
    </html>
