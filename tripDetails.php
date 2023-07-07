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

<!DOCTYPE html>
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

        h3 {
            color: #000000;
            text-align: center;
        }

        .btn btn-primary{
            align-self: center;
            background-color: #1260cc;
            color: #000000;
        }

        .navbar {
            background-color: #1e3f66;
        }

        .nav-item{
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

        /* Add this CSS selector for cell background color */
        td.unavailable {
            background-color: orange;
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

    <h3 style="text-align: center;">Trip Details</h3>
    <div class="d-flex justify-content-center">
        <form class="form-inline" method="GET">
            <div class="input-group">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" style="max-width: 300px;">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </div>
        </form>
    </div>

    <table class="table table-striped table-bordered" style="margin-top: 20px;">
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

    // Check if search form is submitted or if the page is being refreshed
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
        $searchTerm = strtoupper($_GET['search']); // Convert search term to uppercase

        // Prepare the SQL statement with search conditions
        $sql = "SELECT t.TRIP_ID, t.AUTHORITY_NUMBER, t.VEHICLE_ID, t.DRIVER_ID, t.FUEL_CONSUMPTION, t.IN_METER, t.OUT_METER, (t.IN_METER - t.OUT_METER) AS DISTANCE_TRAVELLED, t.REMARKS
                FROM TRIP t
                JOIN VEHICLE v ON t.VEHICLE_ID = v.VEHICLE_ID
                JOIN DRIVER d ON t.DRIVER_ID = d.DRIVER_ID
                WHERE UPPER(t.TRIP_ID) LIKE '%$searchTerm%'";
    } else {
        // Display the data for all trips
        $sql = "SELECT t.TRIP_ID, t.AUTHORITY_NUMBER, t.VEHICLE_ID, t.DRIVER_ID, t.FUEL_CONSUMPTION, t.IN_METER, t.OUT_METER, (t.IN_METER - t.OUT_METER) AS DISTANCE_TRAVELLED, t.REMARKS
                FROM TRIP t
                JOIN VEHICLE v ON t.VEHICLE_ID = v.VEHICLE_ID
                JOIN DRIVER d ON t.DRIVER_ID = d.DRIVER_ID";
    }

    // Prepare the statement
    $stmt = oci_parse($conn, $sql);

    // Execute the statement
    $success = oci_execute($stmt);

    if (!$success) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Fetch and display the data
    echo "<tr>";
    echo "<th>Trip ID</th>";
    echo "<th>Authority Number</th>";
    echo "<th>Vehicle ID</th>";
    echo "<th>Driver ID</th>";
    echo "<th>Fuel Consumption</th>";
    echo "<th>In Meter</th>";
    echo "<th>Out Meter</th>";
    echo "<th>Distance Travelled</th>";
    echo "<th>Remarks</th>";
    echo "</tr>";

    while ($row = oci_fetch_assoc($stmt)) {
        echo "<tr>";
        echo "<td>" . $row['TRIP_ID'] . "</td>";
        echo "<td>" . $row['AUTHORITY_NUMBER'] . "</td>";
        echo "<td>" . $row['VEHICLE_ID'] . "</td>";
        echo "<td>" . $row['DRIVER_ID'] . "</td>";
        echo "<td>" . $row['FUEL_CONSUMPTION'] . "</td>";
        echo "<td>" . $row['IN_METER'] . "</td>";
        echo "<td>" . $row['OUT_METER'] . "</td>";
        echo "<td>" . $row['DISTANCE_TRAVELLED'] . "</td>";
        echo "<td>" . $row['REMARKS'] . "</td>";
        echo "</tr>";
    }

    // Close the connection
    oci_close($conn);
?>


        </tbody>
    </table>
    <div class="text-center">
        <button type="button" class="btn btn-primary d-inline-block" onclick="window.location.href='deletedriver.php'">Remove A Driver</button>
        <button type="button" class="btn btn-primary d-inline-block" onclick="window.location.href='editdriver.php'">Edit Information</button>
    </div>


<div class="text-center" style="margin-top: 20px;">
    <a class="btn btn-primary d-inline-block" href="welcomepage.php">Back</a>
    <a class="btn btn-primary d-inline-block" href="driverentry.php">Next</a>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>
