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
 <div class="container">
        <div class="col-md-6">
            <h3 class="text-center">ADD NEW LEAVE</h3>

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <label for="LeaveID" class="form-label">LEAVE ID</label>
                    <input type="text" class="form-control" id="LeaveID" name="LeaveID" aria-describedby="ID" required>
                    <div id="id" class="form-text">*Required.</div>
                </div>

	 <div class="mb-3">
                    <label for="DriverID" class="form-label">Driver ID</label>
                    <input type="text" class="form-control" id="DriverID" name="DriverID" aria-describedby="ID" required>
                    <div id="id" class="form-text">*Required.</div>
                </div>


                <select class="form-select" id="LeaveType" name="LeaveType" aria-label="leaveType">
        <option selected>LEAVE TYPE</option>
        <option value="Casual">Casual</option>
        <option value="Sick">Sick</option>
        <option value="Annual">Annual</option>
      </select>

                <div class="mb-3">
                    <label for="StartDate" class="form-label">START DATE</label>
                    <input type="date" class="form-control" id="StartDate" name="StartDate" aria-describedby="startDate" required>
                    <div id="startDate" class="form-text">*Required.</div>
                </div>

                <div class="mb-3">
                    <label for="EndDate" class="form-label">END DATE</label>
                    <input type="date" class="form-control" id="EndDate" name="EndDate" aria-describedby="endDate" required>
                    <div id="endDate" class="form-text">*Required.</div>
                </div>

                <div class="mb-3">
                    <label for="LeaveDueDate" class="form-label">LEAVE DUE DATE</label>
                    <input type="date" class="form-control" id="LeaveDueDate" name="LeaveDueDate" aria-describedby="dueDate" required>
                    <div id="dueDate" class="form-text">*Required.</div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

	<div class="text-center" style="margin-top: 60px;">
    <a class="btn btn-primary d-inline-block" href="welcomepage.php">Back</a>
    <a class="btn btn-primary d-inline-block" href="leave.php">Next</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>

<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $leaveId = $_POST['LeaveID'];
    $driverId = $_POST['DriverID'];
    $leaveType = $_POST['LeaveType'];
    $startDate = $_POST['StartDate'];
    $endDate = $_POST['EndDate'];
    $leaveDueDate = $_POST['LeaveDueDate'];

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO LEAVE (LEAVE_ID, DRIVER_ID, TYPE_OF_LEAVE, START_DATE, END_DATE, LEAVE_DUE)
            VALUES (:leaveId, :driverId, :leaveType, TO_DATE(:startDate, 'YYYY-MM-DD'), TO_DATE(:endDate, 'YYYY-MM-DD'), TO_DATE(:leaveDueDate, 'YYYY-MM-DD'))";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":leaveId", $leaveId);
    oci_bind_by_name($stmt, ":driverId", $driverId);
    oci_bind_by_name($stmt, ":leaveType", $leaveType);
    oci_bind_by_name($stmt, ":startDate", $startDate);
    oci_bind_by_name($stmt, ":endDate", $endDate);
    oci_bind_by_name($stmt, ":leaveDueDate", $leaveDueDate);

    if (oci_execute($stmt)) {
        echo '<div style="text-align: center; margin-top: 50px; margin-bottom: 50px; color: white; background-color: navy; padding: 10px;">Leave inserted successfully.</div>';
    } else {
      echo '<div style="text-align: center; margin-top: 50px; margin-bottom: 50px; color: white; background-color: navy; padding: 10px;">Error adding leave entry.</div>';
    }

    oci_free_statement($stmt);
}
?>