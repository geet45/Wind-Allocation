<?php
session_start();

include('config.php');

$limit = 5;
$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$paginationStart = ($page - 1) * $limit;
$next = $page + 1;
$prev = $page - 1;

$query1 = "SELECT COUNT(*) AS email FROM user_req";
$result1 = mysqli_query($conn, $query1);
$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
$total = $row1['email'];
$totalpages = ceil($total / $limit);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['allow'])) {
        $email = $_POST['email'];

        // Fetch user details from user_req table
        $selectQuery = "SELECT * FROM user_req WHERE email = '$email'";
        $userResult = mysqli_query($conn, $selectQuery);
        $userData = mysqli_fetch_array($userResult, MYSQLI_ASSOC);

        if ($userData) {
            $fname = $userData['fname'];
            $lname = $userData['lname'];
            $user_type = $userData['user_type'];
            $company = $userData['company'];
            $phone = $userData['phn_no'];

            // Add user to "users" table with a default password value
            $insertQuery = "INSERT INTO users (fname, lname, email, user_type, company, phn_no, password) VALUES ('$fname', '$lname', '$email', '$user_type', '$company', '0000000000','default_password')";
            mysqli_query($conn, $insertQuery);


            // Delete user from "user_req" table
            $deleteQuery = "DELETE FROM user_req WHERE email = '$email'";
            mysqli_query($conn, $deleteQuery);
        }
    } elseif (isset($_POST['reject'])) {
        $email = $_POST['email'];

        // Delete user from "user_req" table
        $deleteQuery = "DELETE FROM user_req WHERE email = '$email'";
        mysqli_query($conn, $deleteQuery);
    }

    // Redirect to refresh the page
    header("Location: new-user-requests.php");
    exit();
}

$query = "SELECT * FROM user_req LIMIT $paginationStart,$limit";
$result = mysqli_query($conn, $query);
if ($result == FALSE) {
    die(mysqli_error($conn));
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
    <h1 style="text-align: center;">APPROVE/DISAPPROVE USER REQUESTS</h1>
    <br>
    <table>
        <tr>
            <th>Sl no.</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Company</th>
            <th>Accept/Reject</th>
        </tr>

        <tbody>
        <?php $i = $paginationStart + 1; while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo ($row['fname']); ?></td>
                <td><?php echo ($row['lname']); ?></td>
                <td><?php echo ($row['email']); ?></td>
                <td><?php echo ($row['user_type']); ?></td>
                <td><?php echo ($row['company']); ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="email" value="<?php echo ($row['email']); ?>">
                        <button type="submit" name="reject" class="form-control">Reject</button>
                    </form>

                    <form action="" method="post">
                        <input type="hidden" name="email" value="<?php echo ($row['email']); ?>">
                        <button type="submit" name="allow" class="form-control">Allow</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="container pt-5">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <nav aria-label="...">
                    <!-- Pagination code -->
                </nav>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
    </div>

    <p class="text-center"><span class="error"></span><span class="success"></span></p>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
