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
    $VehicleId = $_POST['vehicleID'];
    $kmpl = $_POST['kmpl'];
    $classification = $_POST['classification'];
    $serviceStatus = $_POST['serviceStatus'];

    // Prepare the SQL statement
    $sql = "UPDATE VEHICLE
            SET KMPL = upper(:kmpl),
                CLASSIFICATION = upper(:classification),
                SERVICE_STATUS = upper(:serviceStatus)
            WHERE VEHICLE_ID = upper(:VehicleId)";
    $stmt = oci_parse($conn, $sql);

    // Bind the parameters
    oci_bind_by_name($stmt, ":kmpl", $kmpl);
    oci_bind_by_name($stmt, ":ownerunit", $ownerunit);
    oci_bind_by_name($stmt, ":classification", $classification);
    oci_bind_by_name($stmt, ":serviceStatus", $serviceStatus);
    oci_bind_by_name($stmt, ":VehicleId", $VehicleId);

    // Execute the statement
    $result = oci_execute($stmt);
    if ($result) {
        header("Location: vehicledetails.php");
    } else {
        $error = oci_error($stmt);
        echo '<script>alert("Error: ' . $error['message'] . '");</script>';
    }
}

// Close the Oracle connection
oci_close($conn);
?>



<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    

    <title>Update Information</title>

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
</div>
    <div class="container d-flex justify-content-center align-items-center form-container">
        <div class="col-md-6">
            <h3 class="text-center">UPDATE VEHICLE INFORMATION</h3>

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <label for="VehicleID" class="form-label">VEHICLE ID</label>
                    <input type="text" class="form-control" id="VehicleID" name="vehicleID" aria-describedby="ID"
                        required>
                    <div id="id" class="form-text">*Required.</div>
                </div>

                <div class="mb-3">
                    <label for="kmpl" class="form-label">KMPL</label>
                    <input type="number" class="form-control" id="kmpl" name="kmpl" aria-describedby="kmpl"
                        required>
                    <div id="name" class="form-text">*Required.</div>
                </div>

                <select class="form-select" id="classification" name="classification"
                    aria-label="classification">
                    <option selected>CLASSIFICATION</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select>

                <select class="form-select" id="serviceStatus" name="serviceStatus" aria-label="serviceStatus">
                    <option selected>SERVICE STATUS</option>
                    <option value="SVC">SVC</option>
                    <option value="UNSVC">UNSVC</option>
                </select>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="container mt-5">
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

    // Execute the SELECT query
    $query = "SELECT * FROM VEHICLE where OWNER_UNIT = :username";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':username', $username);
    oci_execute($stmt);
    ?>
        <table class="table table-striped table-bordered" style="margin-top: 20px;">
        <thead class="table-dark">
            <tr>
                <th>Vehicle ID</th>
                <th>Type Of Vehicle</th>
                <th>KMPL</th>
                <th>Date of Induction</th>     
                <th>Classification</th>
                <th>Owner Unit</th>
                <th>Service Status</th>
            </tr>
        </thead>
        <tbody>

            <?php
            // Fetch and display each row of the result
            while ($row = oci_fetch_assoc($stmt)) {
                echo "<tr>";
                echo "<td>" . $row['VEHICLE_ID'] . "</td>";
                echo "<td>" . $row['TYPE_OF_VEHICLE'] . "</td>";
                echo "<td>" . $row['KMPL'] . "</td>";
                echo "<td>" . $row['DATE_OF_INDUCTION'] . "</td>";
                echo "<td>" . $row['CLASSIFICATION'] . "</td>";
                echo "<td>" . $row['OWNER_UNIT'] . "</td>";
                echo "<td>" . $row['SERVICE_STATUS'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>


