<?php
// Check if session has not started and start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./includes/connection_DB.php";
$logged_user = "";
$logged_user = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "";

// Initialize userType with a default value
$userType = "";

// Now, safely check if 'user_type' is in session and update userType accordingly
if (isset($_SESSION['user_type'])) {
    $userType = $_SESSION['user_type'];
    if ($userType == "Staff") {
    }
}
$resultdisplayquery = "SELECT * FROM staff WHERE name = '$logged_user'";
$result = mysqli_query($conn, $resultdisplayquery);

if ($result) {
    $staffResult = mysqli_fetch_assoc($result);
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <?php
    if ($userType == "Staff") {
        echo ('<button class="d-none btn btn-primary mt-5 ms-5" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Menu</button>');

    } else if ($userType == "Admin") {
        echo ('<button class="btn btn-primary mt-5 ms-5" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Menu</button>');
    } ?>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column align-items-center gap-2">
            <div><a class="btn btn-primary d-block" href="admin_registration.php">Admin Registration</a></div>
            <div><a class="btn btn-warning" href="staff_registration.php">Staff Registration Form</a></div>
            <div><a class="btn btn-dark" href="staff_display.php">Show Staff List</a></div>
            <div><a class="btn btn-success" href="subjects_form.php">Subjects Creation</a></div>
            <div><a class="btn btn-danger" href="logout.php">Logout</a></div>
        </div>
    </div>
    <script src="./JS/bootstrap.bundle.min.js"></script>
</body>

</html>