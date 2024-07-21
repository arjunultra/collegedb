<?php
session_start();
session_unset();
session_destroy();
echo "<p class='text-bg-info text-center'>Logout Success</p>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="./CSS/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
</head>

<body>
    <a class="btn btn-success w-25 d-block mx-auto mt-5" href="login.php">Go to Login</a>
    <script>
        setTimeout(function () {
            window.location.href = "login.php";
        }, 10000); // 15 seconds in milliseconds
    </script>
</body>

</html>