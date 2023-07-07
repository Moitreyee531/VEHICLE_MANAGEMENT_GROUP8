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

// Database configuration
$host = 'localhost';
$port = '1521';
$dbName = 'XEPDB1';
$user = 'sayed';
$password = 'sayed';
// Establish a database connection
$connectionString = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST={$host})(PORT={$port}))(CONNECT_DATA=(SERVICE_NAME={$dbName})))";
$conn = oci_connect($user, $password, $connectionString);



// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $tripID = $_POST['tripid'];
    $vehicleID = $_POST['vehicleID'];
    $driverID = $_POST['driverID'];
    $outMeter = $_POST['outmeter'];
    $authNo = $_POST['authNo'];
    $ontrip = 'ON TRIP';

    // Prepare the SQL statement to check driver's availability
    $sqlCheckDriver = "SELECT AVAILABILITY FROM DRIVER WHERE DRIVER_ID = upper(:driverID)";
    $stmtCheckDriver = oci_parse($conn, $sqlCheckDriver);
    oci_bind_by_name($stmtCheckDriver, ':driverID', $driverID);
    oci_execute($stmtCheckDriver);
    $driverRow = oci_fetch_assoc($stmtCheckDriver);

    // Prepare the SQL statement to check vehicle's service status
    $sqlCheckVehicle = "SELECT SERVICE_STATUS FROM VEHICLE WHERE VEHICLE_ID = upper(:vehicleID)";
    $stmtCheckVehicle = oci_parse($conn, $sqlCheckVehicle);
    oci_bind_by_name($stmtCheckVehicle, ':vehicleID', $vehicleID);
    oci_execute($stmtCheckVehicle);
    $vehicleRow = oci_fetch_assoc($stmtCheckVehicle);

    if (!$driverRow) {
        echo "Driver not found.";
    } elseif (!$vehicleRow) {
        echo "Vehicle not found.";
    } else {
        $driverAvailability = $driverRow['AVAILABILITY'];
        $vehicleServiceStatus = $vehicleRow['SERVICE_STATUS'];
    
        if ($driverAvailability == 'ON TRIP') {
            echo "Driver is already on a trip.";
        } elseif ($vehicleServiceStatus == 'ON TRIP') {
            echo "Vehicle is already on a trip.";
        } else {
            // Continue with the trip assignment
            $sql1 = "INSERT INTO trip (TRIP_ID, AUTHORITY_NUMBER, IN_METER, OUT_METER, VEHICLE_ID, DRIVER_ID)
            VALUES (upper(:tripID), upper(:authNo), NULL, upper(:outMeter), upper(:vehicleID), upper(:driverID))";
            $sql2 = "UPDATE DRIVER SET AVAILABILITY = 'ON TRIP' WHERE DRIVER_ID = upper(:driverID)";
            $sql3 = "UPDATE VEHICLE SET SERVICE_STATUS = 'ON TRIP' WHERE VEHICLE_ID = upper(:vehicleID)";
    
            // Prepare the statements
            $stmt1 = oci_parse($conn, $sql1);
            $stmt2 = oci_parse($conn, $sql2);
            $stmt3 = oci_parse($conn, $sql3);
    
            // Bind the values
            oci_bind_by_name($stmt1, ':tripID', $tripID);
            oci_bind_by_name($stmt1, ':authNo', $authNo);
            oci_bind_by_name($stmt1, ':outMeter', $outMeter);
            oci_bind_by_name($stmt1, ':vehicleID', $vehicleID);
            oci_bind_by_name($stmt1, ':driverID', $driverID);
            oci_bind_by_name($stmt2, ':driverID', $driverID);
            oci_bind_by_name($stmt3, ':vehicleID', $vehicleID);
    
            // Execute the statements
            $result1 = oci_execute($stmt1);
            $result2 = oci_execute($stmt2);
            $result3 = oci_execute($stmt3);
    
            if ($result1 && $result2 && $result3) {
                echo "Trip entry created successfully.";
            } else {
                echo "Error creating trip entry.";
            }
    
            // Free the statements
            oci_free_statement($stmt1);
            oci_free_statement($stmt2);
            oci_free_statement($stmt3);
        }
    }
    
    // Free the statements
    oci_free_statement($stmtCheckDriver);
    oci_free_statement($stmtCheckVehicle);
    
}

    // Close the database connection
    oci_close($conn);

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
            color: #000000;
        }

        h2 {
            color: #000000;
            text-align: center;
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

        /* Custom styles for smaller form elements */
        .form-container {
            height: 70vh;
            /* Adjust the value as needed */
            max-width: 800px;
        }

        select.form-select-sm {
            max-width: 200px;
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
</div><br>



    <div class="container d-flex justify-content-center align-items-center form-container">
        <div class="col-md-6">
            <h3 class="text-center">Send To Trip</h3>

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <?php
                    // Check if the vehicle ID query parameter is set in the URL
                    if (isset($_GET['vehicle_id'])) {
                    // Retrieve the vehicle ID from the query parameter
                    $vehicleID = $_GET['vehicle_id'];
                     }// Replace "previous_page.php" with the appropriate page
                    ?>

                    <label for="VehicleID" class="form-label">VEHICLE ID</label>
                    <input type="text" class="form-control" id="VehicleID" name="vehicleID" aria-describedby="ID" value="<?php echo $vehicleID; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tripid" class="form-label">Trip ID</label>
                    <input type="text" class="form-control" id="tripid" name="tripid" aria-describedby="ID"
                        required>
                </div>
                
                <div class="mb-3">
                    <label for="driverid" class="form-label">DRIVER ID</label>
                    <input type="text" class="form-control" id="driverID" name="driverID" aria-describedby="ID"
                        required>
                </div>

                <div class="mb-3">
                    <label for="outmeter" class="form-label">Out Meter</label>
                    <input type="number" class="form-control" id="outmeter" name="outmeter" aria-describedby="outmeter"
                        required>
                    <div id="name" class="form-text">*Required.</div>
                </div>

                <div class="mb-3">
                    <label for="authority" class="form-label">Authority No</label>
                    <input type="text" class="form-control" id="authNo" name="authNo" aria-describedby="ID"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>