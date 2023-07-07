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
    
  
    </head>
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

    <h3 style="text-align: center;">Vehicle Details</h3>
    <div class="d-flex justify-content-center">
        <form class="form-inline" method="GET">
            <div class="input-group">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" style="max-width: 300px;">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </div>
        </form>
    </div>

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
                <th>Service Length</th>
            </tr>
        </thead>
        <tbody>


<!-- Rest of the HTML code continues... -->

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
    $sql = "SELECT VEHICLE_ID, TYPE_OF_VEHICLE, KMPL, DATE_OF_INDUCTION, CLASSIFICATION, OWNER_UNIT, SERVICE_STATUS, (SYSDATE - DATE_OF_INDUCTION) AS SERVICE_LENGTH FROM VEHICLE WHERE OWNER_UNIT = '$username' AND (UPPER(VEHICLE_ID) LIKE '%$searchTerm%' OR UPPER(TYPE_OF_VEHICLE) LIKE '%$searchTerm%' OR UPPER(CLASSIFICATION) LIKE '%$searchTerm%' OR UPPER(KMPL) LIKE '%$searchTerm%' OR UPPER(DATE_OF_INDUCTION) LIKE '%$searchTerm%')";
} else {
    // Display the default query when the page is refreshed or no search term is provided
    $sql = "SELECT VEHICLE_ID, TYPE_OF_VEHICLE, KMPL, DATE_OF_INDUCTION, CLASSIFICATION, OWNER_UNIT, SERVICE_STATUS, (SYSDATE - DATE_OF_INDUCTION) AS SERVICE_LENGTH FROM VEHICLE WHERE OWNER_UNIT = '$username'";
}

// Prepare the statement
$stmt = oci_parse($conn, $sql);

// Execute the statement
oci_execute($stmt);

?>
<?php
// Fetch and display the data
while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['VEHICLE_ID'] . "</td>";
    echo "<td>" . $row['TYPE_OF_VEHICLE'] . "</td>";
    echo "<td>" . $row['KMPL'] . "</td>";
    echo "<td>" . $row['DATE_OF_INDUCTION'] . "</td>";
    echo "<td>" . $row['CLASSIFICATION'] . "</td>";
    echo "<td>" . $row['OWNER_UNIT'] . "</td>";
    echo "<td>" . $row['SERVICE_STATUS'] . "</td>";

    // Calculate the service length
    $serviceLength = round($row['SERVICE_LENGTH']);
    
    if ($serviceLength >= 365) {
        // Convert service length to years
        $years = floor($serviceLength / 365);
        echo "<td>" . $years . " year" . ($years > 1 ? "s" : "") . "</td>";
    } elseif ($serviceLength >= 30) {
        // Convert service length to months
        $months = floor($serviceLength / 30);
        echo "<td>" . $months . " month" . ($months > 1 ? "s" : "") . "</td>";
    } else {
        // Display service length in days
        echo "<td>" . $serviceLength . " day" . ($serviceLength > 1 ? "s" : "") . "</td>";
    }

    echo "</tr>";
}


// Close the connection
oci_close($conn);
?>


        </tbody>
    </table>
    <div class="text-center">
        <button type="button" class="btn btn-primary d-inline-block" onclick="window.location.href='deletevehicle.php'">Remove A Vehicle</button>
        <button type="button" class="btn btn-primary d-inline-block" onclick="window.location.href='editvehicle.php'">Edit Information</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>
