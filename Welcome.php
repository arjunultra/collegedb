<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "collegedb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superuser Dashboard</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <h1 class="main-title text-center">Welcome to the Dashboard</h1>
    <div class="container-xs">
        <div class="btn-container">
            <a target="_blank" class="btn btn-danger" href="admin_registration.php">Admin Registration</a>
            <a target="_blank" class="btn btn-warning" href="staff_registration.php">Staff Registration</a>
            <a target="_blank" class="btn btn-primary" href="staff_display.php">Staff Listing</a>
            <a target="_blank" class="btn btn-success" href="subjects_form.php">Subject Creation</a>
        </div>
    </div>
</body>
<?php mysqli_close($conn); ?>

</html>