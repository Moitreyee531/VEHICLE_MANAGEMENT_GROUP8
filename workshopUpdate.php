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

$updateSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Retrieve form data
    $vehicleID = $_POST['vehicleID'];

    // Declare variables for output parameters
    $reason = null;
    $entryDate = null;

    // Call the procedure to retrieve reason and entry date based on vehicle ID
    $stmt = oci_parse($conn, 'BEGIN GetWorkshopDetails(:vehicleID, :reason, :entryDate); END;');
    oci_bind_by_name($stmt, ':vehicleID', $vehicleID);
    oci_bind_by_name($stmt, ':reason', $reason, 255);
    oci_bind_by_name($stmt, ':entryDate', $entryDate, 255);

    oci_execute($stmt);

    // Check if the procedure returned any data
    if ($reason === null) {
        echo "<p>No workshop details found for the specified vehicle ID.</p>";
    } else {
        echo "<p><span class='highlight'>Reason:</span> " . $reason . "</p>";
        echo "<p><span class='highlight'>Entry Date:</span> " . date('Y-m-d', strtotime($entryDate)) . "</p>";

        // Retrieve and update the remaining form data
        $cost = isset($_POST['cost']) ? $_POST['cost'] : null;
        $returnDate = isset($_POST['returnDate']) ? $_POST['returnDate'] : null;
        $status = isset($_POST['status']) ? $_POST['status'] : null;

        // Prepare the SQL statement
        $sql = "UPDATE WORKSHOP
                SET COST_OF_NUMBER = :cost, DATE_OF_RETURN = TO_DATE(:returnDate, 'YYYY-MM-DD'), MAINTENANCE_STATUS = :status
                WHERE VEHICLE_ID = :vehicleID";

        // Prepare the statement
        $stmt = oci_parse($conn, $sql);

        // Bind the parameters
        oci_bind_by_name($stmt, ":cost", $cost);
        oci_bind_by_name($stmt, ":returnDate", $returnDate);
        oci_bind_by_name($stmt, ":status", $status);
        oci_bind_by_name($stmt, ":vehicleID", $vehicleID);

        // Execute the statement
        $result = oci_execute($stmt, OCI_DEFAULT);

        if ($result) {
            oci_commit($conn);
            $updateSuccess = true;
        } else {
            $error = oci_error($stmt);
            echo "<p>Error: " . $error['message'] . "</p>";
        }

        // Free the statement
        oci_free_statement($stmt);
    }

    // Close the connection
    oci_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
</head>
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
        <h3>Workshop Update</h3>

        <form method="POST">
            <div class="form-group">
                <label for="vehicleID">Vehicle ID:</label>
                <input type="text" id="vehicleID" name="vehicleID" required>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Retrieve Workshop Details</button>
            </div>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Retrieve form data
            $vehicleID = $_POST['vehicleID'];

            // Declare variables for output parameters
            $reason = null;
            $entryDate = null;

            // Call the procedure to retrieve reason and entry date based on vehicle ID
            $stmt = oci_parse($conn, 'BEGIN GetWorkshopDetails(:vehicleID, :reason, :entryDate); END;');
            oci_bind_by_name($stmt, ':vehicleID', $vehicleID);
            oci_bind_by_name($stmt, ':reason', $reason, 255);
            oci_bind_by_name($stmt, ':entryDate', $entryDate, 255);

            oci_execute($stmt);

            // Check if the procedure returned any data
            if ($reason === null) {
                echo "<p>No workshop details found for the specified vehicle ID.</p>";
            } else {
                echo "<p><span class='highlight'>Reason:</span> " . $reason . "</p>";
                echo "<p><span class='highlight'>Entry Date:</span> " . date('Y-m-d', strtotime($entryDate)) . "</p>";

                // Display the update form
                ?>
                <form method="POST">
                    <div class="form-group">
                        <input type="hidden" name="vehicleID" value="<?php echo $vehicleID; ?>">
                    </div>
                    <div class="form-group">
                        <label for="cost">Cost:</label>
                        <input type="number" id="cost" name="cost">
                    </div>
                    <div class="form-group">
                        <label for="returnDate">Return Date:</label>
                        <input type="date" id="returnDate" name="returnDate">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update">Update</button>
                    </div>
                </form>
                <?php
            }

            // Free the statement
            oci_free_statement($stmt);
        }
        ?>

        <form method="POST">
            <div class="form-group">
                <button type="submit" name="logout">Logout</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>


</body>
</html>
