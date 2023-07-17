<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}
              
                

                $query = "SELECT * FROM all_details";
                $result = mysqli_query($conn, $query);
                if ($result == FALSE) {
                    die(mysqli_error());
                    exit();
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
		<h1>Form - C</h1>
		
		<br>
		<table id="myTable" style="width: 85%;">
			<thead>
				<tr>
					<th>Priority</th>
					<th>P.o.C.</th>
					<th>Establishment</th>
					<th>Constsumer Type</th>
					<th>Division</th>
                    <th>Sub-Divishion</th>
                    <th>RR No.</th>
                    <th>Energy wheeled</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<?php  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){ ?>
                                <tr>
                                  <td><?php echo($row['id']); ?></td>
                                  <td><?php echo($row['poc']); ?></td>
								  <td><?php echo($row['establishment']); ?></td>
                                  <td><?php echo($row['consumer_type']); ?></td>
                                  <td><?php echo($row['division']); ?></td>
								  <td><?php echo($row['sub_division']); ?></td>
                                  <td><?php echo($row['rr_no']); ?></td>
                                  <td><?php echo($row['energy_wheeled']); ?></td>
                                  <?php 
                                 } ?>
			</tbody>
		</table>
		<br>
		<button onclick="exportToXLS()">Export to XLS</button>

		<script type="text/javascript">
function exportToXLS(myTable) {
  var htmltable = document.getElementById('myTable');
  
  // Add cell bordering
  var cells = htmltable.getElementsByTagName('td');
  for (var i = 0; i < cells.length; i++) {
    cells[i].style.border = '1px solid black';
  }
  
  // Adjust table width
  htmltable.style.width = '90%';

  var html = htmltable.outerHTML;
  window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
}
</script>

	
</body>
</html>

