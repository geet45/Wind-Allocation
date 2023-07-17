<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}

$estimate = 300000;
$energy = 0;
      

                $query1 = "SELECT COUNT(*) AS priority FROM allocate";
                $result1 = mysqli_query($conn, $query1);
                $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
                $total = $row1['priority'];
                

                $query = "SELECT * FROM allocate";
                $result = mysqli_query($conn, $query);
                if ($result == FALSE) {
                    die(mysqli_error());
                    exit();
                }

				
				// Query to get the number of rows in the table
				$sql = "SELECT COUNT(*) as count FROM allocate";
				$result2 = $conn->query($sql);

				// Check if the query was successful
				if ($result2 === false) {
					die("Error getting row count: " . $conn->error);
				}

				// Get the row count
				$row = $result2->fetch_assoc();
				$count = $row['count'];

				function allocate_resources($conn, $estimate) {
					
					// Query to get resource requests in decreasing priority order
					$sql1 = "SELECT priority, demand, allocated FROM allocate ORDER BY priority ";
					$result3 = mysqli_query($conn, $sql1);
					// Initialize available resources
					$energy = $estimate;
					// Loop through each request and allocate resources if available
					while ($row = mysqli_fetch_assoc($result3)) {
						if ($row['demand'] <= $energy) {
							$energy -= $row['demand'];
							
							$sql4 = "UPDATE allocate SET allocated = {$row['demand']} WHERE priority = {$row['priority']}";
							if ($conn->query($sql4) === FALSE) {
								echo "Error: " . $sql4 . "<br>" . $conn->error;
							}
						} else {
							$sql5 = "UPDATE allocate SET allocated = {$energy} WHERE priority = {$row['priority']}";
							
							$energy = 0;
							if ($conn->query($sql5) === FALSE) {
								echo "Error: " . $sql5 . "<br>" . $conn->error;
							}
						}
					}
				}
				
				
				
				

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
            <li><a href="admin_page.php">Dashboard</a></li>
            <li><a href="new-user-requests.php">Users Request</a></li>
            <li><a href="all_details.php">Form C</a></li>
            <li><a href="announce.php">Annoncements</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
	</div>
	<div class="content">
	<h1 style="font-size: 50px;text-align: center;color: #15188d;">KARNATAKA ENERGY ALLOCATION</h1>
<h1 >Admin Dashboard</h1>

		Estimated Generation : <?php echo $estimate ?><br>
		<br><br>
		<table>
			<thead>
				<tr>
					<th>Priority</th>
					<!--<th>P.o.C.</th>-->
					<th>ITC Group</th>
					<th>Demand</th>
					<th>Allocation</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<?php  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){ ?>
                                <tr>
                                  <td><?php echo($row['priority']); ?></td>
                                  <!--<td><?php echo($row['poc']); ?></td>-->
								  <td><?php echo($row['group_name']); ?></td>
                                  <td><?php echo($row['demand']); ?></td>
                                  <td><?php echo($row['allocated']); ?></td>
								  <?php 
                                 } ?>
			</tbody>
		</table>
		<br>
		<br>
		
		<?php
// Define the function
			

			// Check if the button has been clicked
			if (isset($_POST['allocate'])) {
			// Call the function
			allocate_resources($conn, $estimate);
			}
		?>

		<form method="post">
  			<button id="myButton" class="button-15" role="button" onclick="hideButton()" type="submit" name="allocate">Allocate Energy</button>
		</form>
	</div>
	
</body>
</html>



