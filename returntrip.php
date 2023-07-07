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


// Check the database connection
if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . $e['message']);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $tripID = $_POST['tripID'];
    $vehicleID = $_POST['vehicleID'];
    $driverID = $_POST['driverID'];
    $inMeter = $_POST['inmeter'];
    $remarks = $_POST['remarks'];



// Prepare the SQL statements
$sql1 = "UPDATE TRIP SET IN_METER = :inmeter, REMARKS = :remarks WHERE TRIP_ID = :tripID";
$sql2 = "UPDATE TRIP SET FUEL_CONSUMPTION = (DISTANCE_TRAVELLED / (SELECT KMPL FROM VEHICLE WHERE VEHICLE_ID = :vehicleID)) WHERE TRIP_ID = :tripID";
$sql3 = "UPDATE DRIVER SET AVAILABILITY = UPPER('available') WHERE DRIVER_ID = UPPER(:driverID)";
$sql4 = "UPDATE VEHICLE SET SERVICE_STATUS = UPPER('SVC') WHERE VEHICLE_ID = UPPER(:vehicleID)";

// Prepare the statements
$stmt1 = oci_parse($conn, $sql1);
$stmt2 = oci_parse($conn, $sql2);
$stmt3 = oci_parse($conn, $sql3);
$stmt4 = oci_parse($conn, $sql4);

// Bind the values for the first statement
oci_bind_by_name($stmt1, ':inmeter', $inMeter);
oci_bind_by_name($stmt1, ':remarks', $remarks);
oci_bind_by_name($stmt1, ':tripID', $tripID);

// Bind the values for the second statement
oci_bind_by_name($stmt2, ':vehicleID', $vehicleID);
oci_bind_by_name($stmt2, ':tripID', $tripID);

// Bind the value for the third statement
oci_bind_by_name($stmt3, ':driverID', $driverID);

// Bind the value for the fourth statement
oci_bind_by_name($stmt4, ':vehicleID', $vehicleID);

// Execute the statements
$result1 = oci_execute($stmt1);
$result2 = oci_execute($stmt2);
$result3 = oci_execute($stmt3);
$result4 = oci_execute($stmt4);

if ($result1 && $result2 && $result3 && $result4) {
    echo "Trip record updated successfully.";
} else {
    $e = oci_error($stmt1);
    echo "Error: " . $e['message'];
}

// Free the statements
oci_free_statement($stmt1);
oci_free_statement($stmt2);
oci_free_statement($stmt3);
oci_free_statement($stmt4);

// Close the database connection
oci_close($conn);

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

    <?php
if (isset($_GET['vehicle_id']) && isset($_GET['driver_id']) && isset($_GET['trip_id'])) {
    // Retrieve the values from the URL
    $vehicleID = $_GET['vehicle_id'];
    $driverID = $_GET['driver_id'];
    $tripID = $_GET['trip_id'];
} else {
    // Set default values or handle the situation when parameters are not present
    $vehicleID = '';
    $driverID = '';
    $tripID = '';
}
    ?>


                <div class="container d-flex justify-content-center align-items-center form-container">
             <div class="col-md-6">
        <h3 class="text-center">Returned From Trip</h3>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="VehicleID" class="form-label">VEHICLE ID</label>
                <input type="text" class="form-control" id="VehicleID" name="vehicleID" aria-describedby="ID" value="<?php echo $vehicleID; ?>" required>
            </div>

            <div class="mb-3">
                <label for="tripid" class="form-label">Trip ID</label>
                <input type="text" class="form-control" id="tripID" name="tripID" aria-describedby="ID" value="<?php echo $tripID; ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="driverid" class="form-label">DRIVER ID</label>
                <input type="text" class="form-control" id="driverID" name="driverID" aria-describedby="ID" value="<?php echo $driverID; ?>"
                    required>
            </div>

                <div class="mb-3">
                    <label for="inmeter" class="form-label">In Meter</label>
                    <input type="number" class="form-control" id="inmeter" name="inmeter" aria-describedby="inmeter"
                        required>
                    <div id="name" class="form-text">*Required.</div>
                </div>

                <div class="mb-3">
                    <label for="authority" class="form-label">Remarks</label>
                    <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="ID"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>