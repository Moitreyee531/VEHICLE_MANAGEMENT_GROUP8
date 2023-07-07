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
    
</head>
    <title>Entry of Vehicle into Workshop</title>

    <style>
        body {
            background-color: #b7e9f7;
            color: #000000;
            padding-top: 20px; /* Added padding to top */
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
            margin-bottom: 20px; /* Added margin to bottom */
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

        /* Custom styles for smaller form elements */
        .form-container {
            max-width: 600px;
            margin: 0 auto; /* Center align the form */
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
        }

        select.form-select-sm {
            max-width: 200px;
        }
    </style>


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
<div class="container d-flex justify-content-center align-items-center form-container">
  <div class="col-md-6">
    <h3 class="text-center">ADD VEHICLE INTO WORKSHOP</h3>

    <form method="POST">
  <div class="form-group">
    <label for="vehicleId">Vehicle ID:</label>
    <input type="text" id="vehicleId" name="vehicleId" required>
  </div>
  <div class="form-group">
    <label for="reason">Reason:</label>
    <input type="text" id="reason" name="reason" required>
  </div>
  <div class="form-group">
    <label for="entryDate">Entry Date:</label>
    <input type="date" id="entryDate" name="entryDate" required>
  </div>
  <div class="form-group">
    <label for="maintenanceStatus">Maintenance Status:</label>
    <input type="text" id="maintenanceStatus" name="maintenanceStatus" required>
  </div>
  <div class="form-group">
    <label for="cost">Cost:</label>
    <input type="number" id="cost" name="cost" required>
  </div>
  <div class="form-group">
    <label for="returnDate">Date of Return:</label>
    <input type="date" id="returnDate" name="returnDate" required>
  </div>
  <button type="submit">Submit</button>
</form>
  </div>

<div class="text-center" style="margin-top: 60px;">
    <a class="btn btn-primary d-inline-block" href="welcomepage.php">Back</a>
    <a class="btn btn-primary d-inline-block" href="driverDetails.php">Next</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>


</body>
</html>

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $vehicleId = $_POST['vehicleId'];
  $reason = $_POST['reason'];
  $entryDate = $_POST['entryDate'];
  $maintenanceStatus = $_POST['maintenanceStatus'];
  $cost = $_POST['cost'];
  $returnDate = $_POST['returnDate'];

  // Prepare the SQL statement
  $sql = "INSERT INTO WORKSHOP (VEHICLE_ID, REASON, ENTRY_DATE, MAINTENANCE_STATUS, COST_OF_NUMBER, DATE_OF_RETURN)
          VALUES (:vehicleId, :reason, TO_DATE(:entryDate, 'YYYY-MM-DD'), :maintenanceStatus, :cost, TO_DATE(:returnDate, 'YYYY-MM-DD'))";

  // Prepare the statement
  $stmt = oci_parse($conn, $sql);

  // Bind the parameters
  oci_bind_by_name($stmt, ":vehicleId", $vehicleId);
  oci_bind_by_name($stmt, ":reason", $reason);
  oci_bind_by_name($stmt, ":entryDate", $entryDate);
  oci_bind_by_name($stmt, ":maintenanceStatus", $maintenanceStatus);
  oci_bind_by_name($stmt, ":cost", $cost);
  oci_bind_by_name($stmt, ":returnDate", $returnDate);

  // Execute the statement
  $result = oci_execute($stmt, OCI_DEFAULT);

  if ($result) {
    // Commit the transaction
    oci_commit($conn);

    echo '<div style="text-align: center; margin-top: 50px; margin-bottom: 50px; color: white; background-color: blue; padding: 10px;">Data inserted successfully.</div>';
  } else {
    $e = oci_error($stmt);
    echo "Error: " . htmlentities($e['message']);
  }

  // Clean up
  oci_free_statement($stmt);
  oci_close($conn);
}
?>
