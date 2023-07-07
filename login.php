<?php
session_start(); // Start the session

$connection = oci_connect('sayed', 'sayed', 'localhost:1521/XEPDB1');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "Please enter both username and password.";
    } else {
        // Prepare the SQL query to check the username and password
        $query = "SELECT * FROM unit WHERE UNIT_NAME = :username AND UNIT_PIN = :password";
        $statement = oci_parse($connection, $query);

        // Bind the parameters
        oci_bind_by_name($statement, ':username', $username);
        oci_bind_by_name($statement, ':password', $password);

        // Execute the query
        $result = oci_execute($statement);

        if ($result) {
            // Fetch the row
            $row = oci_fetch_assoc($statement);

            if ($row) {
                // Set the session variables
                $_SESSION['username'] = $row['UNIT_NAME'];

                // Redirect to another page based on the logged-in user
                if ($username === 'ADMIN') {
                    header("Location: adminwelcome.php");
                } else {
                    header("Location: welcomepage.php");
                }
                exit();
            } else {
                echo "Access denied. Invalid username or password.";
            }
        } else {
            $error = oci_error($statement);
            echo "Query execution failed: " . $error['message'];
        }

        oci_free_statement($statement);
    }
}

oci_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #333333;">
    <div style="width: 500px; background-color: #222222; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
        <h2 style="text-align: center; margin-bottom: 30px; font-size: 30px; color: #ffffff;">LOGIN</h2>
        <form action="login.php" method="POST">
            <label for="username" style="display: block; margin-bottom: 20px; font-size: 16px; color: #ffffff;">USER NAME:</label>
            <input type="text" id="username" name="username" required style="width: 95%; padding: 12px; border: 1px solid #cccccc; border-radius: 4px; font-size: 16px;">
            <br><br>
    
            <label for="password" style="display: block; margin-bottom: 20px; font-size: 16px; color: #ffffff;">PASSWORD:</label>
            <input type="password" id="password" name="password" required style="width: 95%; padding: 12px; border: 1px solid #cccccc; border-radius: 4px; font-size: 16px;">
            <br><br>
    
            <input type="submit" value="Login" style="display: block; margin: 0 auto; width: 75%; padding: 12px; background-color: #ff5722; color: #ffffff; border: none; border-radius: 4px; cursor: pointer; font-size: 18px;">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
