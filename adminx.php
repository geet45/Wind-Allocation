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
	
.navbar {
    transition: all 0.4s;
}

.navbar .nav-link {
    color: #fff;
}

.navbar .nav-link:hover,
.navbar .nav-link:focus {
    color: #fff;
    text-decoration: none;
}

.navbar .navbar-brand {
    color: #fff;
}


/* Change navbar styling on scroll */
.navbar.active {
    background: #fff;
    box-shadow: 1px 2px 10px rgba(0, 0, 0, 0.1);
}

.navbar.active .nav-link {
    color: #555;
}

.navbar.active .nav-link:hover,
.navbar.active .nav-link:focus {
    color: #555;
    text-decoration: none;
}

.navbar.active .navbar-brand {
    color: #555;
}


/* Change navbar styling on small viewports */
@media (max-width: 991.98px) {
    .navbar {
        background: #fff;
    }

    .navbar .navbar-brand, .navbar .nav-link {
        color: #555;
    }
}




.text-small {
    font-size: 0.9rem !important;
}


body {
    min-height: 110vh;
    background-color: #4ca1af;
    background-image: linear-gradient(135deg, #4ca1af 0%, #c4e0e5 100%);
}}
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
			on
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

        $(function () {
    $(window).on('scroll', function () {
        if ( $(window).scrollTop() > 10 ) {
            $('.navbar').addClass('active');
        } else {
            $('.navbar').removeClass('active');
        }
    });
});

	</script>
	<!-- Navbar-->
<header class="header">
    <nav class="navbar navbar-expand-lg fixed-top py-3">
        <div class="container"><a href="#" class="navbar-brand text-uppercase font-weight-bold">Transparent Nav</a>
            <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fa fa-bars"></i></button>
            
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="#" class="nav-link text-uppercase font-weight-bold">Home <span class="sr-only">(current)</span></a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-uppercase font-weight-bold">User Requests</a></li>
                    <li class="nav-item"><a href="all_details.php" class="nav-link text-uppercase font-weight-bold">Form C</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-uppercase font-weight-bold">Settings</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link text-uppercase font-weight-bold">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
	<div class="content">
	<h1 style = font-size: 80px>Your Text here </h1>
		<h1>Admin Dashboard</h1>
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



