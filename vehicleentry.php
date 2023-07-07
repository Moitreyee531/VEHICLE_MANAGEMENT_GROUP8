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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Entry of New Driver</title>

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

<div class="container form-container">
    <h3>ADD NEW VEHICLE</h3>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4">
        <div class="mb-3">
            <label for="VehicleID" class="form-label">VEHICLE ID</label>
            <input type="text" class="form-control" id="VehicleID" name="VehicleID" aria-describedby="ID">
            <div id="id" class="form-text">*Required.</div>
        </div>

        <label for="vehicletype" class="form-label">VEHICLE TYPE</label>
        <select class="form-select" name="vehicletype" aria-label="vehicletype">
          
          <option value="JEEP">JEEP</option>
          <option value="3 TON">3 TON</option>
          <option value="PICK UP">PICK UP</option>
          <option value="MOTORCYCLE">MOTORCYCLE</option>
          <option value="STAFF CAR">STAFF CAR</option>
          <option value="COASTER">COASTER</option>
        </select>

        <div class="mb-3">
            <label for="kmpl" class="form-label">KM PER LITER</label>
            <input type="number" class="form-control" id="kmpl" name="kmpl" aria-describedby="kmpl">
            <div id="id" class="form-text">*Required.</div>
        </div>

        <label for="vehclassification" class="form-label">VEHICLE CLASSIFICATION</label>
        <select class="form-select" name="vehicleclassification" aria-label="vehicleclassification">
          <option value="A">A</option>
          <option value="B">B</option>
  
        </select>


        <label for="serviceststus" class="form-label">SERVICE STATUS</label>
        <select class="form-select" name="service" aria-label="service">
        <option value="SVC">SVC</option>
        <option value="UNSVC">UNSVC</option>
        </select>

        <div class="mb-3">
            <label for="inductiondate" class="form-label">DATE OF INDUCTION</label>
            <input type="date" class="form-control" id="inductiondate" name="inductiondate" aria-describedby="inductiondate">
            <div id="id" class="form-text">*Required.</div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
  $vehicleId = $_POST['VehicleID'];
  $vehicleType = $_POST['vehicletype'];
    $kmpl = $_POST['kmpl'];
    $classification = $_POST['vehicleclassification'];
    $inductionDate = $_POST['inductiondate'];
    $serviceStatus = $_POST['service'];


  // Calculate service length
 // $currentDate = date('Y-m-d');
 // $inductionDateTime = new DateTime($inductionDate);
 // $currentDateTime = new DateTime($currentDate);
 // $serviceLengthInterval = $inductionDateTime->diff($currentDateTime);
 // $serviceLength = $serviceLengthInterval->format('%y years, %m months, %d days');

  // Prepare the SQL statement
  $sql = "INSERT INTO VEHICLE (VEHICLE_ID, TYPE_OF_VEHICLE, KMPL, CLASSIFICATION, DATE_OF_INDUCTION, SERVICE_STATUS, OWNER_UNIT, SERVICE_LENGTH)
  VALUES (upper(:vehicleId), upper(:vehicleType), :kmpl, upper(:classification), TO_DATE(:inductionDate, 'YYYY-MM-DD') , upper(:serviceStatus), upper(:username), :serviceLength)";


  // Prepare the statement
  $stmt = oci_parse($conn, $sql);

  // Bind the parameters
  oci_bind_by_name($stmt, ":vehicleId", $vehicleId);
  oci_bind_by_name($stmt, ":vehicleType", $vehicleType);
  oci_bind_by_name($stmt, ":kmpl", $kmpl);
  oci_bind_by_name($stmt, ":classification", $classification);
  oci_bind_by_name($stmt, ":inductionDate", $inductionDate);
  oci_bind_by_name($stmt, ":serviceStatus", $serviceStatus);
  oci_bind_by_name($stmt, ":username", $username);
  oci_bind_by_name($stmt, ":serviceLength", $serviceLength);

  // Execute the statement
  $result = oci_execute($stmt, OCI_DEFAULT);

  if ($result) {
    // Commit the transaction
    oci_commit($conn);

    echo "Data inserted successfully.";
  } else {
    $e = oci_error($stmt);
    echo "Error: " . htmlentities($e['message']);
  }

  // Clean up
  oci_free_statement($stmt);
  oci_close($conn);
}
?>
