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
    $driverId = $_POST['DriverID'];
    $driverName = $_POST['DriverName'];
    $driverQualification = $_POST['driverclassification'];
    $availabilityStatus = $_POST['availability'];

    // Prepare the SQL statement
    $sql = "UPDATE DRIVER
            SET DRIVER_NAME = upper(:driverName),
                QUALIFICATION = upper(:qualification),
                AVAILABILITY = upper(:availability)
            WHERE DRIVER_ID = upper(:driverId)";
    $stmt = oci_parse($conn, $sql);

    // Bind the parameters
    oci_bind_by_name($stmt, ":driverName", $driverName);
    oci_bind_by_name($stmt, ":qualification", $driverQualification);
    oci_bind_by_name($stmt, ":availability", $availabilityStatus);
    oci_bind_by_name($stmt, ":driverId", $driverId);

    // Execute the statement
    $result = oci_execute($stmt);
    if ($result) {
        header("Location: driverdetails.php");
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">

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
				 <li><a class="dropdown-item" href="driverDetails.php">Driver Details</a></li>
                            <li><a class="dropdown-item" href="editdriver.php">Update Driver Information</a></li>
                             <li><a class="dropdown-item" href="deletedriver.php">Remove Driver</a></li>
                            <li><a class="dropdown-item" href="driverentry.php">Add Driver</a></li>
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
                            Vehicle Management
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="editvehicle.php">Edit Vehicle Information</a></li>
                            <li><a class="dropdown-item" href="vehicleDetails.php">Vehicle Details</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="vehicleentry.php">Add a Vehicle</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Maintenance
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="workshop.php">Workshop</a></li>
                            <li><a class="dropdown-item" href="workshopUpdate.php">Update Workshop</a></li>
                        </ul>
                    </li>
                </ul>

                <form method="POST" action="" class="d-flex">
                    <button class="btn btn-outline-light" type="submit" name="logout">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="important-notice">
        <span class="notice-text">Important notice</span>
    </div>
    <div class="container d-flex justify-content-center align-items-center form-container">
        <div class="col-md-6">
            <h3 class="text-center">UPDATE DRIVER INFORMATION</h3>

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="mb-3">
                    <label for="DriverID" class="form-label">PERSONAL ID</label>
                    <input type="text" class="form-control" id="DriverID" name="DriverID" aria-describedby="ID"
                        required>
                    <div id="id" class="form-text">*Required.</div>
                </div>

                <div class="mb-3">
                    <label for="DriverName" class="form-label">NAME</label>
                    <input type="text" class="form-control" id="DriverName" name="DriverName" aria-describedby="name"
                        required>
                    <div id="name" class="form-text">*Required.</div>
                </div>

                <select class="form-select" id="unitname" name="unitname" aria-label="unitname">
                    <option selected>UNIT</option>
                    <option value="10 SIG BN">10 SIG BN</option>
                    <option value="11 SIG BN">11 SIG BN</option>
                    <option value="ASSB">ASSB</option>
                    <option value="86 BDE HQ">86 BDE HQ</option>
                    <option value="EW COY">EW COY</option>
                </select>

                <select class="form-select" id="driverclassification" name="driverclassification"
                    aria-label="driverclassification">
                    <option selected>QUALIFICATION</option>
                    <option value="LIGHT">LIGHT</option>
                    <option value="HEAVY">HEAVY</option>
                    <option value="STAFF CAR">STAFF CAR</option>
                </select>

                <select class="form-select" id="availability" name="availability" aria-label="availability">
                    <option selected>AVAILABILITY STATUS</option>
                    <option value="AVAILABLE">AVAILABLE</option>
                    <option value="UNAVAILABLE">UNAVAILABLE</option>
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
    $query = "SELECT * FROM DRIVER WHERE UNIT_NAME = '$username'";
    $stmt = oci_parse($conn, $query);
    oci_execute($stmt);
    ?>
    <table class="table table-striped" style="background-color: white;"> <!-- Add the style here -->
        <thead>
            <tr style="background-color: black; color: white;" >
                <th scope="col">PERSONAL ID</th>
                <th scope="col">NAME</th>
                <th scope="col">UNIT</th>
                <th scope="col">QUALIFICATION</th>
                <th scope="col">AVAILABILITY STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch and display each row of the result
            while ($row = oci_fetch_assoc($stmt)) {
                echo "<tr>";
                echo "<td>" . $row['DRIVER_ID'] . "</td>";
                echo "<td>" . $row['DRIVER_NAME'] . "</td>";
                echo "<td>" . $row['UNIT_NAME'] . "</td>";
                echo "<td>" . $row['QUALIFICATION'] . "</td>";
                echo "<td>" . $row['AVAILABILITY'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="text-center" style="margin-bottom: 20px;">
    <a class="btn btn-primary d-inline-block" href="welcomepage.php">Back</a>
    <a class="btn btn-primary d-inline-block" href="driverentry.php">Next</a>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>


