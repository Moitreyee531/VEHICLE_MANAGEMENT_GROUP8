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
    
    <style>
        body {
            background-color: #b7e9f7;
            color: #ffffff;
        }

        h2 {
            color: #000000;
            text-align: center;
        }

        .navbar {
            background-color: #1e3f66;
        }

        .nav-item {
            color: #ffffff;
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

        @keyframes slide {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-1200%);
            }
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
                            <li><a class="dropdown-item" href="admindriverdetails.php">Driver Details</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Vehicle Management
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="adminvehicle.php">Vehicle Details</a></li>
                          
                        </ul>
                    </li>
			
			 <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Leave Management
                        </a>
                        <ul class="dropdown-menu">
				 <li><a class="dropdown-item" href="adminleave.php">Leave Details</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Maintenance
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="adminworkshop.php">Workshop</a></li>
                        </ul>
                    </li>
<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Trip
                        </a>
                        <ul class="dropdown-menu">
 <li><a class="dropdown-item" href="admintrip.php">Trip Details</a></li>
                            
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

    <h4 style="text-align: center; color: black;">Available Vehicle</h4>
    <table class="table table-striped table-bordered" style="margin-top: 20px;">
        <thead class="table-dark">
            <tr>
                <th>Vehicle ID</th>
                <th>Type</th>
                <th>Classification</th>
                <th>KMPL</th>
                <th>Fuel Consumption</th>
                <th>     </th>

            </tr>
        </thead>
        <tbody>


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

            $serviceStatus = 'SVC';

            $sql1 = 'SELECT UNIQUE vehicle.vehicle_id, type_of_vehicle, classification, KMPL, SUM(trip.fuel_consumption) AS total_fuel_consumption FROM vehicle LEFT OUTER JOIN trip ON vehicle.vehicle_id = trip.vehicle_id  WHERE VEHICLE.SERVICE_STATUS = :serviceStatus  GROUP BY vehicle.vehicle_id, type_of_vehicle, classification, KMPL, trip.fuel_consumption';

            // Prepare the statement
            $stmt = oci_parse($conn, $sql1);
            oci_bind_by_name($stmt, ":serviceStatus", $serviceStatus);


            
            // Execute the statement
            $success = oci_execute($stmt);
            
            if (!$success) {
                $e = oci_error($stmt);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            
            // Fetch and display the data
            while ($row = oci_fetch_assoc($stmt)) {
                echo "<tr>";
                echo "<td>" . $row['VEHICLE_ID'] . "</td>";
                echo "<td>" . $row['TYPE_OF_VEHICLE'] . "</td>";
                echo "<td>" . $row['CLASSIFICATION'] . "</td>";
                echo "<td>" . $row['KMPL'] . "</td>";
                echo "<td>" . $row['TOTAL_FUEL_CONSUMPTION'] . "</td>";
                echo "<td><a href='tripentry.php?vehicle_id=" . $row['VEHICLE_ID'] . "' class='btn btn-primary d-inline-block'>Send To Trip</a></td>";
                echo "</tr>";
            }
            
            
            ?>
        </tbody>
    </table>



    <h4 style="text-align: center; color: black;">On Leave</h4>
    <table class="table table-striped table-bordered" style="margin-top: 20px;">
        <thead class="table-dark">
            <tr>
                <th>Vehicle ID</th>
                <th>Type</th>
                <th>SERVICR STATUS</th>
                <th>TRIP ID</th>
                <th>AUTHORITY NUMBER</th>
                <th>DRIVER NAME</th>


                <th>     </th>

            </tr>
        </thead>
        <tbody>


        <?php

            $serviceStatus2 = 'ON TRIP';
            $sql3 = 'SELECT vehicle.vehicle_id, type_of_vehicle, service_status, trip.driver_id, trip_id, authority_number, driver.driver_name
            FROM vehicle
            LEFT JOIN trip ON vehicle.vehicle_id = trip.vehicle_id
            LEFT JOIN driver ON driver.driver_id = trip.driver_id
            WHERE vehicle.service_status = :serviceStatus2
            AND trip.in_meter IS NULL';


            
            // Prepare the statement
            $stmtt = oci_parse($conn, $sql3);
            oci_bind_by_name($stmtt, ":serviceStatus2", $serviceStatus2);
            
            // Execute the statement
            $success = oci_execute($stmtt);
            
            if (!$success) {
                $e = oci_error($stmtt);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            
            // Fetch and display the data


            
            while ($row = oci_fetch_assoc($stmtt)) {
                echo "<tr>";
                echo "<td>" . $row['VEHICLE_ID'] . "</td>";
                echo "<td>" . $row['TYPE_OF_VEHICLE'] . "</td>";
                echo "<td>" . $row['SERVICE_STATUS'] . "</td>";
                echo "<td>" . $row['TRIP_ID'] . "</td>";
                echo "<td>" . $row['AUTHORITY_NUMBER'] . "</td>";
                echo "<td>" . $row['DRIVER_NAME'] . "</td>";

                echo "<td><a href='returntrip.php?vehicle_id=" . $row['VEHICLE_ID'] . "&trip_id=" . $row['TRIP_ID'] . "&driver_id=" . $row['DRIVER_ID'] . "' class='btn btn-primary d-inline-block'>End Trip</a></td>";
                echo "</tr>";
            }
            
            
            ?>
        </tbody>
    </table>
    <h4 style="text-align: center; color: black;">Leave Due Soon</h4>
    <table class="table table-striped table-bordered" style="margin-top: 20px;">
        <thead class="table-dark">
            <tr>
                <th>Driver ID</th>
                <th>Driver Name</th>
                <th>Qualification</th>
                <th>Availability</th>
                <th>Unit Name</th>
                <th>Leave Due</th>

            </tr>
        </thead>
        <tbody>


        <?php
 
 $sql2 = "SELECT DRIVER.DRIVER_ID, DRIVER.DRIVER_NAME, DRIVER.QUALIFICATION, DRIVER.AVAILABILITY, DRIVER.UNIT_NAME, LEAVE.LEAVE_DUE FROM DRIVER JOIN LEAVE ON DRIVER.DRIVER_ID = LEAVE.DRIVER_ID WHERE LEAVE.LEAVE_DUE >= TO_DATE('" . date('Y-m-d') . "', 'YYYY-MM-DD')  ORDER BY LEAVE.LEAVE_DUE ASC";

 // Prepare the statement
 $stmnt = oci_parse($conn, $sql2);

 
 // Execute the statement
 $success = oci_execute($stmnt);
 
 if (!$success) {
     $e = oci_error($stmnt);
     trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
 }
 
 // Fetch and display the data
 while ($row = oci_fetch_assoc($stmnt)) {
     echo "<tr>";
     echo "<td>" . $row['DRIVER_ID'] . "</td>";
     echo "<td>" . $row['DRIVER_NAME'] . "</td>";
     echo "<td>" . $row['QUALIFICATION'] . "</td>";
     echo "<td>" . $row['AVAILABILITY'] . "</td>";
     echo "<td>" . $row['UNIT_NAME'] . "</td>";
     echo "<td>" . $row['LEAVE_DUE'] . "</td>";
     echo "</tr>";
 }
 
            // Close the connection
            oci_close($conn);
            ?>
        </tbody>
    </table>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
