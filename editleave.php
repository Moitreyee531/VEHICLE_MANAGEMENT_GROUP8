<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Access the session variable
$username = $_SESSION['username'];

// Handle logout button click
if (isset($_POST['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: login.php");
    exit();
}
?>


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <title>Delete Driver</title>

    <style>
        body {
            background-color: #b7e9f7;
            color: #000000;
        }

        h3 {
            color: #000000;
            text-align: center;
        }

        .navbar {
            background-color: #1e3f66;
        }

        .navbar .nav-link {
            color: #ffffff !important;
        }

        .navbar .nav-link:hover {
            color: #f5f5f5;
        }

        .dropdown-menu {
            background-color: #92dff3;
        }

        .dropdown-menu a.dropdown-item {
            color: #ffffff;
        }

        .dropdown-menu a.dropdown-item:hover {
            color: #f5f5f5;
        }

        .dropdown-menu a.dropdown-item.active,
        .dropdown-menu a.dropdown-item:active {
            font-weight: bold;
            color: #ffffff;
        }

        .important-notice {
            position: relative;
            overflow: hidden;
            background-color: #91bad6;
            color: #000000;
            padding: 10px;
        }

        .important-notice span {
            position: absolute;
            top: 25%;
            right: 0;
            transform: translateX(100%);
            white-space: nowrap;
            animation: slide 25s linear infinite;
            margin-top: -0.5em;
        }

        @keyframes slide {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-1200%);
            }
        }
    </style>
</head>
<body>
<h2 style="text-align: center;">MT Management System</h2>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="welcomepage.php">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Driver Management
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="editdriver.php">Update Driver Information</a></li>
                        <li><a class="dropdown-item" href="driverDetails.php">Driver Details</a></li>
                         <li><a class="dropdown-item" href="deletedriver.php">Remove Driver</a></li>
                        <li><a class="dropdown-item" href="driverentry.php">Add a Driver</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Vehicle Management
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="editvehicle.php">Edit Vehicle Information</a></li>
                        <li><a class="dropdown-item" href="vehicleDetails.php">Vehicle Details</a></li>
                      
                        <li><a class="dropdown-item" href="vehicleentry.php">Add a Vehicle</a></li>
                    </ul>
                </li>
        
         <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Leave Management
                    </a>
                    <ul class="dropdown-menu">
             <li><a class="dropdown-item" href="leave.php">Leave Details</a></li>
                        <li><a class="dropdown-item" href="editleave.php">Update Leave Information</a></li>
                         <li><a class="dropdown-item" href="deleteleave.php">Remove Leave</a></li>
                        <li><a class="dropdown-item" href="leaveentry.php">Add Leave</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Maintenance
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="workshopDetails.php">Workshop</a></li>
                        <li><a class="dropdown-item" href="workshopUpdate.php">Update Workshop</a></li>
<li><a class="dropdown-item" href="workshopentry.php">Add To Workshop</a></li>
<li><a class="dropdown-item" href="deleteworkshop.php">Remove From Workshop</a></li>
                    </ul>
                </li>
<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Trip
                    </a>
                    <ul class="dropdown-menu">
<li><a class="dropdown-item" href="tripDetails.php">Trip Details</a></li>
                        
                    </ul>
                </li>
        </div>
    </div>
    <form method="POST" action="" class="d-flex">
                <button class="btn btn-outline-light" type="submit" name="logout">Logout</button>
            </form>
</nav>

<div class="important-notice">
    <span class="notice-text">Important notice</span>
</div>


<body>
<h2>Leave Update</h2>

<div class="container">
    <?php
    // Oracle database connection parameters
    $host = 'localhost';
    $port = '1521';
    $dbName = 'XEPDB1';
    $user = 'sayed';
    $password = 'sayed';
    // Establish a database connection
    $connectionString = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST={$host})(PORT={$port}))(CONNECT_DATA=(SERVICE_NAME={$dbName})))";
$conn = oci_connect($user, $password, $connectionString);

    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Check if the LEAVE table exists
    $query = "SELECT COUNT(*) FROM user_tables WHERE table_name = 'LEAVE'";
    $statement = oci_parse($conn, $query);
    oci_execute($statement);
    $row = oci_fetch_array($statement, OCI_ASSOC);

    if ($row['COUNT(*)'] == 0) {
        echo "<p>LEAVE table does not exist. Please create the table first.</p>";
        exit();
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $leaveId = $_POST['leaveId'];
        $typeOfLeave = $_POST['typeOfLeave'];
        $leaveDue = $_POST['leaveDue'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $driverId = $_POST['driverId'];

        // Update the leave record in the database
        $query = "UPDATE LEAVE SET TYPE_OF_LEAVE = :typeOfLeave, LEAVE_DUE = TO_DATE(:leaveDue, 'YYYY-MM-DD'), START_DATE = TO_DATE(:startDate, 'YYYY-MM-DD'), END_DATE = TO_DATE(:endDate, 'YYYY-MM-DD'), DRIVER_ID = :driverId WHERE LEAVE_ID = :leaveId";
        $statement = oci_parse($conn, $query);
        oci_bind_by_name($statement, ':typeOfLeave', $typeOfLeave);
        oci_bind_by_name($statement, ':leaveDue', $leaveDue);
        oci_bind_by_name($statement, ':startDate', $startDate);
        oci_bind_by_name($statement, ':endDate', $endDate);
        oci_bind_by_name($statement, ':driverId', $driverId);
        oci_bind_by_name($statement, ':leaveId', $leaveId);

        $result = oci_execute($statement);

        if ($result) {
            echo "<p>Leave record updated successfully.</p>";
        } else {
            echo "<p>Failed to update leave record.</p>";
        }
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label for="leaveId">Leave ID:</label>
            <input type="text" name="leaveId" id="leaveId" class="form-control" required>
        </div>
	<div class="form-group">
            <label for="driverId">Driver ID:</label>
            <input type="text" name="driverId" id="driverId" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="typeOfLeave">Type of Leave:</label>
            <input type="text" name="typeOfLeave" id="typeOfLeave" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="leaveDue">Leave Due:</label>
            <input type="date" name="leaveDue" id="leaveDue" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="startDate">Start Date:</label>
            <input type="date" name="startDate" id="startDate" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="endDate">End Date:</label>
            <input type="date" name="endDate" id="endDate" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-save">Save</button>

    </form>
</div>


<div class="container mt-5">
    <?php

    // Execute the SELECT query
    $query = "SELECT * FROM LEAVE, DRIVER WHERE LEAVE.DRIVER_ID = DRIVER.DRIVER_ID AND DRIVER.UNIT_NAME = :username";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':username', $username);
    oci_execute($stmt);
    
    // Define column names before fetching rows
    oci_define_by_name($stmt, 'LEAVE_ID', $leaveId);
    oci_define_by_name($stmt, 'DRIVER_ID', $driverId);
    oci_define_by_name($stmt, 'TYPE_OF_LEAVE', $typeOfLeave);
    oci_define_by_name($stmt, 'LEAVE_DUE', $leaveDue);
    oci_define_by_name($stmt, 'START_DATE', $startDate);
    oci_define_by_name($stmt, 'END_DATE', $endDate);
    oci_define_by_name($stmt, 'DURATION', $duration);
    ?>
    <table class="table table-striped" style="background-color: white;">
        <thead>
            <tr style="background-color: black; color: white;">
                <th>Leave ID</th>
                <th>Driver ID</th>
                <th>Type of Leave</th>
                <th>Leave Due</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch and display each row of the result
            while ($row = oci_fetch_assoc($stmt)) {
                echo "<tr>";
                echo "<td>" . $leaveId . "</td>";
                echo "<td>" . $driverId . "</td>";
                echo "<td>" . $typeOfLeave . "</td>";
                echo "<td>" . $leaveDue . "</td>";
                echo "<td>" . $startDate . "</td>";
                echo "<td>" . $endDate . "</td>";
                echo "<td>" . $duration . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>


<div class="text-center" style="margin-bottom: 20px;">
    <a class="btn btn-primary d-inline-block" href="welcomepage.php">Back</a>
    <a class="btn btn-primary d-inline-block" href="leaveentry.php">Next</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
