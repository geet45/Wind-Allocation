<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_name'])) {
    header('location: login_form.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Announcement</title>
    <script>
        function showMessage(message) {
            alert(message);
        }

        function confirmAction(action) {
            var confirmation = confirm("Are you sure you want to " + action + "?");
            if (confirmation) {
                return true;
            } else {
                return false;
            }
        }
    </script>
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

        /* keyframes for the announcements marquee animation */
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>
</head>

<body>
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
        <h2>Add Announcement</h2>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (empty($_POST['title']) || empty($_POST['description'])) {
                ;
            } else {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                $created_at = date('Y-m-d H:i:s');

                // Prepare the SQL statement
                $sql = "INSERT INTO announcements (title, description, is_active, created_at)
                        VALUES (?, ?, ?, ?)";

                // Prepare the statement
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    echo '<script>showMessage("Failed to prepare statement.");</script>';
                } else {
                    // Bind parameters and execute the statement
                    $stmt->bind_param("ssis", $title, $description, $is_active, $created_at);
                    if ($stmt->execute()) {
                        echo '<script>showMessage("Announcement added successfully.");</script>';
                    } else {
                        echo '<script>showMessage("Failed to add announcement.");</script>';
                    }

                    // Close the statement
                    $stmt->close();
                }
            }
        }
        ?>

        <form method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br><br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br><br>
            <label for="is_active">Active:</label>
            <input type="checkbox" id="is_active" name="is_active"><br><br>
            <input type="submit" value="Add Announcement">
        </form>

        <h2>Announcements</h2>

        <?php
        // Handle delete action
        if (isset($_POST['delete'])) {
            if (isset($_POST['selected'])) {
                $selected = $_POST['selected'];
                foreach ($selected as $announcement) {
                    $data = json_decode($announcement, true);
                    $title = $data['title'];
                    $created_at = $data['created_at'];

                    // Prepare the SQL statement
                    $sql_delete = "DELETE FROM announcements WHERE title = ? AND created_at = ?";

                    // Prepare the statement
                    $stmt = $conn->prepare($sql_delete);
                    if (!$stmt) {
                        echo '<script>showMessage("Failed to prepare statement.");</script>';
                    } else {
                        // Bind parameters and execute the statement
                        $stmt->bind_param("ss", $title, $created_at);
                        if ($stmt->execute()) {
                            echo '<script>showMessage("Selected announcements deleted successfully.");</script>';
                        } else {
                            echo '<script>showMessage("Failed to delete selected announcements.");</script>';
                        }

                        // Close the statement
                        $stmt->close();
                    }
                }
            } else {
                echo '<script>showMessage("No announcements selected for deletion.");</script>';
            }
        }

        // Handle change status action
        if (isset($_POST['change_status'])) {
            if (isset($_POST['selected'])) {
                $selected = $_POST['selected'];
                foreach ($selected as $announcement) {
                    $data = json_decode($announcement, true);
                    $title = $data['title'];
                    $created_at = $data['created_at'];

                    // Prepare the SQL statement
                    $sql_update = "UPDATE announcements SET is_active = !is_active WHERE title = ? AND created_at = ?";

                    // Prepare the statement
                    $stmt = $conn->prepare($sql_update);
                    if (!$stmt) {
                        echo '<script>showMessage("Failed to prepare statement.");</script>';
                    } else {
                        // Bind parameters and execute the statement
                        $stmt->bind_param("ss", $title, $created_at);
                        if ($stmt->execute()) {
                            echo '<script>showMessage("Selected announcements status changed successfully.");</script>';
                        } else {
                            echo '<script>showMessage("Failed to change status of selected announcements.");</script>';
                        }

                        // Close the statement
                        $stmt->close();
                    }
                }
            } else {
                echo '<script>showMessage("No announcements selected for status change.");</script>';
            }
        }

        // Fetch announcements from the table
        $sql_select = "SELECT * FROM announcements";
        $result = $conn->query($sql_select);

        if ($result->num_rows > 0) {
            // Display the announcements in a table
            echo '<form method="POST">';
            echo '<table>';
            echo '<tr><th>Title</th><th>Description</th><th>Is Active</th><th>Created At</th><th>Action</th></tr>';

            while ($row = $result->fetch_assoc()) {
                $title = $row["title"];
                $description = $row["description"];
                $is_active = $row["is_active"];
                $created_at = $row["created_at"];

                echo '<tr>';
                echo '<td>' . $title . '</td>';
                echo '<td>' . $description . '</td>';
                echo '<td>' . ($is_active ? 'Active' : 'Inactive') . '</td>';
                echo '<td>' . $created_at . '</td>';
                echo '<td><input type="checkbox" name="selected[]" value=\'{"title":"' . $title . '","created_at":"' . $created_at . '"}\'></td>';
                echo '</tr>';
            }

           echo '</table>';
echo '<br>';
echo '<input type="submit" class="button-15" name="delete" value="Delete Selected" onclick="return confirmAction(\'delete the selected announcements\')">';
echo '<input type="submit" class="button-15" name="change_status" value="Change Status" onclick="return confirmAction(\'change the status of selected announcements\')">';
echo '</form>';

        } else {
            echo "No announcements found.";
        }

        // Close the database connection
        $conn->close();
        ?>

        <div id="confirmation-container"></div>
        <script>
            function showMessage(message) {
                alert(message);
            }
        </script>
    </div>
</body>

</html>
