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

<?php
            $host = 'localhost';
            $port = '1521';
            $dbName = 'XEPDB1';
            $user = 'sayed';
            $password = 'sayed';

            // Establish a database connection
           

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the driver ID from the form submission
    $driverID = $_POST['DriverID'];

    // Create a connection to the Oracle database
    $connectionString = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST={$host})(PORT={$port}))(CONNECT_DATA=(SERVICE_NAME={$dbName})))";
    $conn = oci_connect($user, $password, $connectionString);
    // Check if the connection was successful
    if (!$conn) {
        $error = oci_error();
        die("Failed to connect to the database: " . $error['message']);
    }

    // Delete associated records from the "LEAVE" table
$deleteLeaveSql = 'DELETE FROM "LEAVE" WHERE LEAVE.DRIVER_ID = upper(:driverID)';
$deleteLeaveStmt = oci_parse($conn, $deleteLeaveSql);
oci_bind_by_name($deleteLeaveStmt, ':driverID', $driverID);
oci_execute($deleteLeaveStmt);
oci_free_statement($deleteLeaveStmt);

    // Prepare the SQL statement to delete the driver entry
    $deleteDriverSql = "DELETE FROM DRIVER WHERE DRIVER_ID = upper(:driverID)";
    $deleteDriverStmt = oci_parse($conn, $deleteDriverSql);
    oci_bind_by_name($deleteDriverStmt, ':driverID', $driverID);

    // Execute the delete statement
    $deleteResult = oci_execute($deleteDriverStmt);

    // Check if the delete operation was successful
    if ($deleteResult) {
        // Redirect to driverDetails.php after a short delay
        header("refresh:3;url=driverDetails.php");
    } else {
        $error = oci_error($deleteDriverStmt);
        echo '<div class="alert alert-danger mt-4">Failed to delete driver entry: ' . $error['message'] . '</div>';
    }

    // Free the statement and close the connection
    oci_free_statement($deleteDriverStmt);
    oci_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
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
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h3 class="text-center mt-4">Delete Driver</h3>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <label for="DriverID" class="form-label">Driver ID</label>
                    <input type="text" class="form-control" id="DriverID" name="DriverID" required>
                </div>
                <button type="submit" class="btn btn-primary">Remove</button>
            </form>
        </div>
    </div>
</div>


<div class="text-center" style="margin-top: 20px;">
    <a class="btn btn-primary d-inline-block" href="welcomepage.php">Back</a>
    <a class="btn btn-primary d-inline-block" href="driverDetails.php">Next</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>
